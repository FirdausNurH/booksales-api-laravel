<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AuthorController extends Controller
{
    /**
     * GET /api/authors
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
     * GET /api/authors/{author}
     */
    public function show(Author $author): JsonResponse
    {
        $author->load(['books' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }]);

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
                        'isbn'            => $book->isbn,
                        'formatted_price' => 'Rp ' . number_format($book->price, 0, ',', '.'),
                        'stock'           => $book->stock,
                        'status'          => $book->status,
                        'status_label'    => $book->status === 'available' ? 'Tersedia' : 'Habis',
                    ];
                }),
                'created_at' => $author->created_at->toIso8601String(),
                'updated_at' => $author->updated_at->toIso8601String(),
            ],
        ], 200);
    }

    /**
     * PUT /api/authors/{author}
     */
    public function update(Request $request, Author $author): JsonResponse
    {
        $validated = $request->validate([
            'name'  => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:authors,email,' . $author->id,
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
     * DELETE /api/authors/{author}
     */
    public function destroy(Author $author): JsonResponse
    {
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
     * GET /api/authors/{author}/books
     */
    public function books(Author $author): JsonResponse
    {
        $books = $author->books()->orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'message' => "Daftar buku dari {$author->name} berhasil diambil",
            'data'    => $books->map(function ($book) {
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
                    'created_at'       => $book->created_at->toIso8601String(),
                ];
            }),
        ], 200);
    }
}