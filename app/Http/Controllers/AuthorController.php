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

        // Fitur pencarian berdasarkan nama
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

    // --- Method lainnya (show, update, destroy, books) tetap dipertahankan jika sudah ada ---
}