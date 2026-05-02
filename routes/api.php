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

// Route Statistik (custom)
Route::get('/stats', [StatsController::class, 'index']);

// Route khusus Author (harus sebelum apiResource agar tidak dianggap parameter {author})
Route::get('/authors/{author}/books', [AuthorController::class, 'books']);

// apiResource: Genre (otomatis mendaftarkan index, store, show, update, destroy)
Route::apiResource('genres', GenreController::class);

// apiResource: Author (otomatis mendaftarkan index, store, show, update, destroy)
Route::apiResource('authors', AuthorController::class);

// apiResource: Books
Route::apiResource('books', BookController::class);