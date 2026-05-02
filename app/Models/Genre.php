<?php

namespace App\Models;

/*
|--------------------------------------------------------------------------
| Model — Genre
|--------------------------------------------------------------------------
|
| Model bertugas menyediakan data. Pada kasus ini data bersumber
| dari array statis (tanpa database). Masing-masing genre memiliki
| atribut: id, name, description, book_count, dan status.
|
*/

class Genre
{
    /**
     * Data array statis berisi 5 genre.
     *
     * @var array
     */
    protected $genres = [
        [
            'id'          => 1,
            'name'        => 'Fiction',
            'description' => 'Karya sastra yang berasal dari imajinasi pengarang, bukan berdasarkan fakta nyata. Meliputi berbagai sub-genre seperti literary fiction dan contemporary fiction.',
            'book_count'  => 38,
            'status'      => 'active',
        ],
        [
            'id'          => 2,
            'name'        => 'Non-Fiction',
            'description' => 'Buku yang berisi fakta, informasi nyata, dan pengetahuan dunia nyata. Termasuk biografi, sejarah, sains populer, dan self-help.',
            'book_count'  => 42,
            'status'      => 'active',
        ],
        [
            'id'          => 3,
            'name'        => 'Science Fiction',
            'description' => 'Genre yang mengeksplorasi konsep futuristik, teknologi canggih, perjalanan antariksa, dan dampak sains terhadap masyarakat manusia.',
            'book_count'  => 27,
            'status'      => 'active',
        ],
        [
            'id'          => 4,
            'name'        => 'Fantasy',
            'description' => 'Karya yang berlatar dunia fantasi dengan elemen magic, makhluk mitologis, dan sistem dunia yang dibangun dari imajinasi pengarang.',
            'book_count'  => 23,
            'status'      => 'active',
        ],
        [
            'id'          => 5,
            'name'        => 'Mystery',
            'description' => 'Genre yang berpusat pada penyelesaian kejahatan atau teka-teki. Pembaca diajak berpikir kritis mengikuti jejak petunjuk bersama detektif.',
            'book_count'  => 12,
            'status'      => 'inactive',
        ],
    ];

    /**
     * Mengambil seluruh data genre.
     *
     * @return array
     */
    public function getAll()
    {
        return $this->genres;
    }

    /**
     * Mengambil satu data genre berdasarkan ID.
     *
     * @param int $id
     * @return array|null
     */
    public function findById($id)
    {
        foreach ($this->genres as $genre) {
            if ($genre['id'] === $id) {
                return $genre;
            }
        }
        return null;
    }
}