<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AuthorController extends Controller
{
    /**
     * GET /api/authors
     * Read all data author
     */
    public function index(Request $request): JsonResponse
    {
        $query = Author::withCount('books');

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $authors = $query->orderBy('name', 'asc')->paginate($request->get('per_page', 10));

        return response()->json([
            'success' => true,
            'message' => 'Daftar penulis berhasil diambil',
            'meta'    => [
                'current_page' => $authors->currentPage(),
                'last_page'    => $authors->lastPage(),
                'per_page'     => $authors->perPage(),
                'total'        => $authors->total(),
            ],
            'data' => $authors->map(function ($author) {
                return [
                    'id'          => $author->id,
                    'name'        => $author->name,
                    'email'       => $author->email,
                    'bio'         => $author->bio,
                    'books_count' => $author->books_count,
                    'created_at'  => $author->created_at->toIso8601String(),
                ];
            }),
        ], 200);
    }

    /**
     * POST /api/authors
     * Create data author baru
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:authors,email',
            'bio'   => 'nullable|string',
        ]);

        $author = Author::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Penulis berhasil ditambahkan',
            'data'    => [
                'id'         => $author->id,
                'name'       => $author->name,
                'email'      => $author->email,
                'bio'        => $author->bio,
                'created_at' => $author->created_at->toIso8601String(),
                'updated_at' => $author->updated_at->toIso8601String(),
            ],
        ], 201);
    }

    /**
     * GET /api/authors/{id}
     * Show detail data author + Validasi 404
     */
    public function show($id): JsonResponse
    {
        $author = Author::with('books')->find($id);

        if (!$author) {
            return response()->json([
                'success' => false,
                'message' => 'Data penulis dengan ID ' . $id . ' tidak ditemukan',
                'data'    => null,
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail penulis berhasil diambil',
            'data'    => [
                'id'    => $author->id,
                'name'  => $author->name,
                'email' => $author->email,
                'bio'   => $author->bio,
                'books' => $author->books->map(function ($book) {
                    return [
                        'id'              => $book->id,
                        'title'           => $book->title,
                        'formatted_price' => 'Rp ' . number_format($book->price, 0, ',', '.'),
                    ];
                }),
                'created_at' => $author->created_at->toIso8601String(),
                'updated_at' => $author->updated_at->toIso8601String(),
            ],
        ], 200);
    }

    /**
     * PUT /api/authors/{id}
     * Update data author + Validasi 404
     */
    public function update(Request $request, $id): JsonResponse
    {
        $author = Author::find($id);

        if (!$author) {
            return response()->json([
                'success' => false,
                'message' => 'Data penulis dengan ID ' . $id . ' tidak ditemukan',
                'data'    => null,
            ], 404);
        }

        $validated = $request->validate([
            'name'  => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:authors,email,' . $id,
            'bio'   => 'nullable|string',
        ]);

        $author->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Penulis berhasil diperbarui',
            'data'    => [
                'id'         => $author->id,
                'name'       => $author->name,
                'email'      => $author->email,
                'bio'        => $author->bio,
                'created_at' => $author->created_at->toIso8601String(),
                'updated_at' => $author->updated_at->toIso8601String(),
            ],
        ], 200);
    }

    /**
     * DELETE /api/authors/{id}
     * Destroy data author + Validasi 404
     */
    public function destroy($id): JsonResponse
    {
        $author = Author::find($id);

        if (!$author) {
            return response()->json([
                'success' => false,
                'message' => 'Data penulis dengan ID ' . $id . ' tidak ditemukan',
                'data'    => null,
            ], 404);
        }

        $authorName   = $author->name;
        $booksDeleted = $author->books()->count();
        $author->delete();

        return response()->json([
            'success' => true,
            'message' => "Penulis \"{$authorName}\" berhasil dihapus beserta {$booksDeleted} bukunya",
            'data'    => null,
        ], 200);
    }

    /**
     * GET /api/authors/{id}/books
     * (Route khusus di luar apiResource)
     */
    public function books($id): JsonResponse
    {
        $author = Author::find($id);

        if (!$author) {
            return response()->json([
                'success' => false,
                'message' => 'Data penulis dengan ID ' . $id . ' tidak ditemukan',
                'data'    => null,
            ], 404);
        }

        $books = $author->books()->orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'message' => "Daftar buku dari {$author->name} berhasil diambil",
            'data'    => $books->map(function ($book) {
                return [
                    'id'              => $book->id,
                    'title'           => $book->title,
                    'formatted_price' => 'Rp ' . number_format($book->price, 0, ',', '.'),
                    'stock'           => $book->stock,
                    'status'          => $book->status,
                ];
            }),
        ], 200);
    }
}