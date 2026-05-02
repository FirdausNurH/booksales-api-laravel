<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\StatsController;

/*
|--------------------------------------------------------------------------
| BookSales API Routes
|--------------------------------------------------------------------------
*/

// =============================================
// ROUTE PUBLIK (Tanpa Autentikasi)
// Bisa diakses siapa saja (Read All & Show)
// =============================================
Route::get('/stats', [StatsController::class, 'index']);

// Author Publik
Route::apiResource('authors', AuthorController::class)->only([
    'index', 'show'
]);

// Genre Publik
Route::apiResource('genres', GenreController::class)->only([
    'index', 'show'
]);

// Books Publik (Read All & Show)
Route::apiResource('books', BookController::class)->only([
    'index', 'show'
]);


// =============================================
// ROUTE ADMIN (Dilindungi Middleware 'admin')
// Hanya bisa diakses jika membawa Header X-Admin-Key yang benar
// Berisi fitur Create, Update, Destroy
// =============================================
Route::middleware('admin')->group(function () {

    // Route khusus relasi (tetap di dalam group admin)
    Route::get('/authors/{author}/books', [AuthorController::class, 'books']);

    // Author Admin (Create, Update, Destroy)
    Route::apiResource('authors', AuthorController::class)->only([
        'store', 'update', 'destroy'
    ]);

    // Genre Admin (Create, Update, Destroy)
    Route::apiResource('genres', GenreController::class)->only([
        'store', 'update', 'destroy'
    ]);

    // Books Admin (Create, Update, Destroy)
    Route::apiResource('books', BookController::class)->only([
        'store', 'update', 'destroy'
    ]);
});