<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use Illuminate\Http\JsonResponse;

class StatsController extends Controller
{
    /**
     * GET /api/stats
     */
    public function index(): JsonResponse
    {
        $totalBooks     = Book::count();
        $totalAuthors   = Author::count();
        $availableBooks = Book::where('status', 'available')->count();
        $outOfStock     = Book::where('status', 'out_of_stock')->count();
        $totalStock     = Book::sum('stock');
        $avgPrice       = Book::avg('price');
        $minPrice       = Book::min('price');
        $maxPrice       = Book::max('price');
        $totalInventory = Book::sum('price') * Book::sum('stock');

        $mostExpensive = Book::with('author')->orderByDesc('price')->first();
        $cheapest      = Book::with('author')->orderBy('price')->first();
        $mostStocked   = Book::with('author')->orderByDesc('stock')->first();
        $topAuthor     = Author::withCount('books')->orderByDesc('books_count')->first();

        return response()->json([
            'success' => true,
            'message' => 'Statistik BookSales berhasil diambil',
            'data'    => [
                'summary' => [
                    'total_books'       => $totalBooks,
                    'total_authors'     => $totalAuthors,
                    'available_books'   => $availableBooks,
                    'out_of_stock'      => $outOfStock,
                    'total_stock_units' => (int) $totalStock,
                ],
                'pricing' => [
                    'average_price'           => round((float) $avgPrice, 2),
                    'formatted_average_price' => 'Rp ' . number_format($avgPrice, 0, ',', '.'),
                    'lowest_price'            => (float) $minPrice,
                    'formatted_lowest_price'  => 'Rp ' . number_format($minPrice, 0, ',', '.'),
                    'highest_price'           => (float) $maxPrice,
                    'formatted_highest_price' => 'Rp ' . number_format($maxPrice, 0, ',', '.'),
                    'total_inventory_value'   => (float) $totalInventory,
                    'formatted_inventory_value' => 'Rp ' . number_format($totalInventory, 0, ',', '.'),
                ],
                'highlights' => [
                    'most_expensive' => $mostExpensive ? [
                        'title'           => $mostExpensive->title,
                        'formatted_price' => 'Rp ' . number_format($mostExpensive->price, 0, ',', '.'),
                        'author'          => $mostExpensive->author->name,
                    ] : null,
                    'cheapest' => $cheapest ? [
                        'title'           => $cheapest->title,
                        'formatted_price' => 'Rp ' . number_format($cheapest->price, 0, ',', '.'),
                        'author'          => $cheapest->author->name,
                    ] : null,
                    'most_stocked' => $mostStocked ? [
                        'title'  => $mostStocked->title,
                        'stock'  => $mostStocked->stock,
                        'author' => $mostStocked->author->name,
                    ] : null,
                    'top_author' => $topAuthor ? [
                        'name'        => $topAuthor->name,
                        'books_count' => $topAuthor->books_count,
                    ] : null,
                ],
            ],
        ], 200);
    }
}