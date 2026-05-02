<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class GenreController extends Controller
{
    /**
     * GET /api/genres
     * Read all data genre
     */
    public function index(Request $request): JsonResponse
    {
        $query = Genre::query();

        // Fitur pencarian berdasarkan nama
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $genres = $query->orderBy('name', 'asc')->paginate($request->get('per_page', 10));

        return response()->json([
            'success' => true,
            'message' => 'Daftar genre berhasil diambil',
            'meta'    => [
                'current_page' => $genres->currentPage(),
                'last_page'    => $genres->lastPage(),
                'per_page'     => $genres->perPage(),
                'total'        => $genres->total(),
            ],
            'data' => $genres->map(function ($genre) {
                return [
                    'id'          => $genre->id,
                    'name'        => $genre->name,
                    'description' => $genre->description,
                    'created_at'  => $genre->created_at->toIso8601String(),
                    'updated_at'  => $genre->updated_at->toIso8601String(),
                ];
            }),
        ], 200);
    }

    /**
     * POST /api/genres
     * Create data genre baru
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255|unique:genres,name',
            'description' => 'nullable|string',
        ]);

        $genre = Genre::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Genre berhasil ditambahkan',
            'data'    => [
                'id'          => $genre->id,
                'name'        => $genre->name,
                'description' => $genre->description,
                'created_at'  => $genre->created_at->toIso8601String(),
                'updated_at'  => $genre->updated_at->toIso8601String(),
            ],
        ], 201);
    }
}