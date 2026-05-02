<?php
use App\Http\Controllers\BookController;
Route::get('/books', [BookController::class, 'index'])->name('books.index');