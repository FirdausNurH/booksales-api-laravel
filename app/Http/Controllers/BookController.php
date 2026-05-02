<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class BookController extends Controller
{
    /**
     * GET /api/books
     */
    public function index(Request $request): JsonResponse
    {
        $query = Book::with('author');

        if ($request->has('available_only') && $request->boolean('available_only')) {
            $query->where('status', 'available');
        }

        if ($request->has('author_id')) {
            $query->where('author_id', $request->author_id);
        }

        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $sortBy  = $request->get('sort_by', 'created_at');
        $sortDir = $request->get('sort_dir', 'desc');

        if (in_array($sortBy, ['title', 'price', 'stock', 'created_at'])) {
            $query->orderBy($sortBy, $sortDir === 'asc' ? 'asc' : 'desc');
        }

        $books = $query->paginate($request->get('per_page', 10));

        return response()->json([
            'success' => true,
            'message' => 'Daftar buku berhasil diambil',
            'meta'    => [
                'current_page' => $books->currentPage(),
                'last_page'    => $books->lastPage(),
                'per_page'     => $books->perPage(),
                'total'        => $books->total(),
            ],
            'data' => $books->map(function ($book) {
                return [
                    'id'               => $book->id,
                    'title'            => $book->title,
                    'isbn'             => $book->isbn,
                    'price'            => (float) $book->price,
                    'formatted_price'  => 'Rp ' . number_format($book->price, 0, ',', '.'),
                    'stock'            => $book->stock,
                    'status'           => $book->status,
                    'status_label'     => $book->status === 'available' ? 'Tersedia' : 'Habis',
                    'description'      => $book->description,
                    'cover'            => $book->cover,
                    'author'           => [
                        'id'   => $book->author->id,
                        'name' => $book->author->name,
                    ],
                    'created_at'       => $book->created_at->toIso8601String(),
                ];
            }),
        ], 200);
    }

    /**
     * POST /api/books
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'isbn'        => 'required|string|max:20|unique:books,isbn',
            'author_id'   => 'required|exists:authors,id',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'description' => 'nullable|string',
            'cover'       => 'nullable|string|url',
        ]);

        $validated['status'] = $validated['stock'] > 0 ? 'available' : 'out_of_stock';

        $book = Book::create($validated);
        $book->load('author');

        return response()->json([
            'success' => true,
            'message' => 'Buku berhasil ditambahkan',
            'data'    => [
                'id'               => $book->id,
                'title'            => $book->title,
                'isbn'             => $book->isbn,
                'price'            => (float) $book->price,
                'formatted_price'  => 'Rp ' . number_format($book->price, 0, ',', '.'),
                'stock'            => $book->stock,
                'status'           => $book->status,
                'status_label'     => $book->status === 'available' ? 'Tersedia' : 'Habis',
                'description'      => $book->description,
                'cover'            => $book->cover,
                'author'           => [
                    'id'   => $book->author->id,
                    'name' => $book->author->name,
                ],
                'created_at'       => $book->created_at->toIso8601String(),
                'updated_at'       => $book->updated_at->toIso8601String(),
            ],
        ], 201);
    }

    /**
     * GET /api/books/{book}
     */
    public function show(Book $book): JsonResponse
    {
        $book->load('author');

        $relatedBooks = Book::where('author_id', $book->author_id)
            ->where('id', '!=', $book->id)
            ->select('id', 'title', 'price', 'status')
            ->get()
            ->map(function ($b) {
                return [
                    'id'              => $b->id,
                    'title'           => $b->title,
                    'formatted_price' => 'Rp ' . number_format($b->price, 0, ',', '.'),
                    'status'          => $b->status,
                ];
            });

        return response()->json([
            'success' => true,
            'message' => 'Detail buku berhasil diambil',
            'data'    => [
                'id'               => $book->id,
                'title'            => $book->title,
                'isbn'             => $book->isbn,
                'price'            => (float) $book->price,
                'formatted_price'  => 'Rp ' . number_format($book->price, 0, ',', '.'),
                'stock'            => $book->stock,
                'status'           => $book->status,
                'status_label'     => $book->status === 'available' ? 'Tersedia' : 'Habis',
                'description'      => $book->description,
                'cover'            => $book->cover,
                'author'           => [
                    'id'    => $book->author->id,
                    'name'  => $book->author->name,
                    'email' => $book->author->email,
                    'bio'   => $book->author->bio,
                ],
                'related_books'    => $relatedBooks,
                'created_at'       => $book->created_at->toIso8601String(),
                'updated_at'       => $book->updated_at->toIso8601String(),
            ],
        ], 200);
    }

    /**
     * PUT /api/books/{book}
     */
    public function update(Request $request, Book $book): JsonResponse
    {
        $validated = $request->validate([
            'title'       => 'sometimes|string|max:255',
            'isbn'        => 'sometimes|string|max:20|unique:books,isbn,' . $book->id,
            'author_id'   => 'sometimes|exists:authors,id',
            'price'       => 'sometimes|numeric|min:0',
            'stock'       => 'sometimes|integer|min:0',
            'description' => 'nullable|string',
            'cover'       => 'nullable|string|url',
        ]);

        if ($request->has('stock')) {
            $validated['status'] = $validated['stock'] > 0 ? 'available' : 'out_of_stock';
        }

        $book->update($validated);
        $book->load('author');

        return response()->json([
            'success' => true,
            'message' => 'Buku berhasil diperbarui',
            'data'    => [
                'id'               => $book->id,
                'title'            => $book->title,
                'isbn'             => $book->isbn,
                'price'            => (float) $book->price,
                'formatted_price'  => 'Rp ' . number_format($book->price, 0, ',', '.'),
                'stock'            => $book->stock,
                'status'           => $book->status,
                'status_label'     => $book->status === 'available' ? 'Tersedia' : 'Habis',
                'description'      => $book->description,
                'cover'            => $book->cover,
                'author'           => [
                    'id'   => $book->author->id,
                    'name' => $book->author->name,
                ],
                'created_at'       => $book->created_at->toIso8601String(),
                'updated_at'       => $book->updated_at->toIso8601String(),
            ],
        ], 200);
    }

    /**
     * DELETE /api/books/{book}
     */
    public function destroy(Book $book): JsonResponse
    {
        $bookTitle = $book->title;
        $book->delete();

        return response()->json([
            'success' => true,
            'message' => "Buku \"{$bookTitle}\" berhasil dihapus",
            'data'    => null,
        ], 200);
    }
}