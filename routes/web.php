<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\AuthorController;

/*
|--------------------------------------------------------------------------
| Web Routes — Booksales
|--------------------------------------------------------------------------
|
| Router menerima request HTTP dari browser, lalu mengarahkan
| ke Controller yang sesuai berdasarkan URL.
|
*/

Route::get('/', function () {
    return view('dashboard');
});

Route::get('/genres', [GenreController::class, 'index'])->name('genres.index');

Route::get('/authors', [AuthorController::class, 'index'])->name('authors.index');