<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TransaksiController extends Controller
{
    /**
     * READ ALL (Hanya Admin)
     */
    public function index(): JsonResponse
    {
        // Mengambil data dari relasi Model (Eager Loading)
        $transaksis = Transaksi::with(['user', 'book'])->latest()->paginate(10);

        return response()->json([
            'success' => true,
            'message' => 'Data seluruh transaksi berhasil diambil (Admin)',
            'data' => $transaksis->map(function ($t) {
                return [
                    'id'         => $t->id,
                    'customer'   => $t->user->name,
                    'book_title' => $t->book->title,
                    'quantity'   => $t->quantity,
                    'total_price'=> 'Rp ' . number_format($t->total_price, 0, ',', '.'),
                    'status'     => $t->status,
                    'date'       => $t->created_at->toIso8601String(),
                ];
            })
        ], 200);
    }

    /**
     * CREATE (Hanya Customer yang Login)
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'book_id'  => 'required|exists:books,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $book = Book::find($validated['book_id']);

        // Cek stok
        if ($book->stock < $validated['quantity']) {
            return response()->json([
                'success' => false, 
                'message' => 'Stok buku tidak mencukupi'
            ], 400);
        }

        $totalPrice = $book->price * $validated['quantity'];

        $transaksi = Transaksi::create([
            'user_id'     => auth()->id(), // Otomatis ambil ID customer yang login
            'book_id'     => $book->id,
            'quantity'    => $validated['quantity'],
            'total_price' => $totalPrice,
            'status'      => 'success',
        ]);

        // Kurangi stok buku
        $book->decrement('stock', $validated['quantity']);
        if ($book->stock == 0) {
            $book->update(['status' => 'out_of_stock']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Transaksi berhasil dibuat',
            'data'    => $transaksi
        ], 201);
    }

    /**
     * SHOW (Hanya Customer yang Login, dan hanya boleh lihat transaksinya sendiri)
     */
    public function show($id): JsonResponse
    {
        $transaksi = Transaksi::with(['user', 'book'])->find($id);

        if (!$transaksi) {
            return response()->json(['success' => false, 'message' => 'Transaksi tidak ditemukan'], 404);
        }

        // Keamanan: Cek apakah transaksi ini milik customer yang sedang login
        if ($transaksi->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Anda tidak memiliki akses ke transaksi ini'], 403);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail transaksi berhasil diambil',
            'data' => [
                'id'               => $transaksi->id,
                'book_title'       => $transaksi->book->title,
                'book_price'       => 'Rp ' . number_format($transaksi->book->price, 0, ',', '.'),
                'quantity'         => $transaksi->quantity,
                'total_price'      => 'Rp ' . number_format($transaksi->total_price, 0, ',', '.'),
                'status'           => $transaksi->status,
                'transaction_date' => $transaksi->created_at->toIso8601String(),
            ]
        ], 200);
    }

    /**
     * UPDATE (Hanya Customer yang Login, dan hanya boleh update transaksinya sendiri)
     */
    public function update(Request $request, $id): JsonResponse
    {
        $transaksi = Transaksi::with('book')->find($id);

        if (!$transaksi) {
            return response()->json(['success' => false, 'message' => 'Transaksi tidak ditemukan'], 404);
        }

        if ($transaksi->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Anda tidak memiliki akses untuk mengubah transaksi ini'], 403);
        }

        $validated = $request->validate([
            'quantity' => 'sometimes|required|integer|min:1',
            'status'   => 'sometimes|required|in:cancelled',
        ]);

        // Jika customer membatalkan pesanan, kembalikan stok
        if ($request->has('status') && $validated['status'] === 'cancelled') {
            $transaksi->book->increment('stock', $transaksi->quantity);
            if ($transaksi->book->stock > 0) {
                $transaksi->book->update(['status' => 'available']);
            }
            $transaksi->update(['status' => 'cancelled']);
        }

        // Jika customer mengubah jumlah quantity
        if ($request->has('quantity')) {
            $book = $transaksi->book;
            $oldQty = $transaksi->quantity;
            $newQty = $validated['quantity'];

            if ($newQty > ($book->stock + $oldQty)) {
                return response()->json(['success' => false, 'message' => 'Stok tidak mencukupi untuk perubahan ini'], 400);
            }

            $book->increment('stock', $oldQty);
            $book->decrement('stock', $newQty);
            if ($book->stock == 0) $book->update(['status' => 'out_of_stock']);
            
            $validated['total_price'] = $book->price * $newQty;
            $transaksi->update($validated);
        }

        return response()->json([
            'success' => true,
            'message' => 'Transaksi berhasil diperbarui',
            'data'    => $transaksi->fresh()
        ], 200);
    }

    /**
     * DESTROY (Hanya Admin)
     */
    public function destroy($id): JsonResponse
    {
        $transaksi = Transaksi::find($id);

        if (!$transaksi) {
            return response()->json(['success' => false, 'message' => 'Transaksi tidak ditemukan'], 404);
        }

        $transaksi->delete();

        return response()->json([
            'success' => true,
            'message' => "Transaksi ID {$id} berhasil dihapus secara permanen oleh Admin",
            'data'    => null
        ], 200);
    }
}