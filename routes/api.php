<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\StatsController;

/*
|--------------------------------------------------------------------------
| BookSales API Routes
|--------------------------------------------------------------------------
*/

// =============================================
// ROUTE PUBLIK (Tanpa Autentikasi)
// =============================================
Route::get('/stats', [StatsController::class, 'index']);

Route::apiResource('authors', AuthorController::class)->only(['index', 'show']);
Route::apiResource('genres', GenreController::class)->only(['index', 'show']);
Route::apiResource('books', BookController::class)->only(['index', 'show']);


// =============================================
// ROUTE ADMIN (Dilindungi Middleware 'admin')
// Menggunakan Header: X-Admin-Key
// =============================================
Route::middleware('admin')->group(function () {
    Route::get('/authors/{author}/books', [AuthorController::class, 'books']);

    Route::apiResource('authors', AuthorController::class)->only(['store', 'update', 'destroy']);
    Route::apiResource('genres', GenreController::class)->only(['store', 'update', 'destroy']);
    Route::apiResource('books', BookController::class)->only(['store', 'update', 'destroy']);

    // TRANSAKSI: Read All & Destroy (Khusus Admin)
    Route::apiResource('transaksis', TransaksiController::class)->only(['index', 'destroy']);
});


// =============================================
// ROUTE CUSTOMER (Dilindungi Middleware 'auth:sanctum')
// Menggunakan Header: Authorization: Bearer {token}
// =============================================
Route::middleware('auth:sanctum')->group(function () {
    
    // TRANSAKSI: Create, Show, Update (Khusus Customer)
    Route::apiResource('transaksis', TransaksiController::class)->only(['store', 'show', 'update']);
});