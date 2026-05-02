<?php

namespace App\Http\Controllers;

use App\Models\Genre;

/*
|--------------------------------------------------------------------------
| Controller — GenreController
|--------------------------------------------------------------------------
|
| Controller menerima request dari Route, kemudian mengambil data
| dari Model (Genre), lalu meneruskannya ke View agar ditampilkan.
| Controller berperan sebagai perantara antara Model dan View.
|
*/

class GenreController extends Controller
{
    /**
     * Menampilkan seluruh data genre ke view.
     *
     * Alur MVC:
     * 1. Route (web.php) menerima GET /genres
     * 2. Controller ini dipanggil
     * 3. Mengambil data dari Model Genre
     * 4. Meneruskan data ke View genres.index
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Langkah 1: Instance Model
        $genreModel = new Genre();

        // Langkah 2: Ambil data dari Model
        $genres = $genreModel->getAll();

        // Langkah 3: Kirim data ke View
        return view('genres.index', compact('genres'));
    }
}