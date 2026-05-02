<?php

namespace App\Http\Controllers;

use App\Models\Author;

/*
|--------------------------------------------------------------------------
| Controller — AuthorController
|--------------------------------------------------------------------------
|
| Sama seperti GenreController, controller ini mengambil data author
| dari Model, lalu meneruskannya ke View untuk ditampilkan.
|
*/

class AuthorController extends Controller
{
    /**
     * Menampilkan seluruh data author ke view.
     *
     * Alur MVC:
     * 1. Route (web.php) menerima GET /authors
     * 2. Controller ini dipanggil
     * 3. Mengambil data dari Model Author
     * 4. Meneruskan data ke View authors.index
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Langkah 1: Instance Model
        $authorModel = new Author();

        // Langkah 2: Ambil data dari Model
        $authors = $authorModel->getAll();

        // Langkah 3: Kirim data ke View
        return view('authors.index', compact('authors'));
    }
}