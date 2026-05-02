<?php

namespace App\Models;

/*
|--------------------------------------------------------------------------
| Model — Author
|--------------------------------------------------------------------------
|
| Model bertugas menyediakan data author. Sama seperti Genre,
| data bersumber dari array statis. Masing-masing author memiliki
| atribut: id, name, country, specialty, book_count, dan status.
|
*/

class Author
{
    /**
     * Data array statis berisi 5 author.
     *
     * @var array
     */
    protected $authors = [
        [
            'id'         => 1,
            'name'       => 'J.K. Rowling',
            'country'    => 'Inggris',
            'specialty'  => 'Fantasy',
            'book_count' => 12,
            'status'     => 'active',
        ],
        [
            'id'         => 2,
            'name'       => 'George R.R. Martin',
            'country'    => 'Amerika Serikat',
            'specialty'  => 'Fantasy',
            'book_count' => 8,
            'status'     => 'active',
        ],
        [
            'id'         => 3,
            'name'       => 'Stephen King',
            'country'    => 'Amerika Serikat',
            'specialty'  => 'Mystery',
            'book_count' => 64,
            'status'     => 'active',
        ],
        [
            'id'         => 4,
            'name'       => 'Agatha Christie',
            'country'    => 'Inggris',
            'specialty'  => 'Mystery',
            'book_count' => 73,
            'status'     => 'active',
        ],
        [
            'id'         => 5,
            'name'       => 'J.R.R. Tolkien',
            'country'    => 'Inggris',
            'specialty'  => 'Fantasy',
            'book_count' => 14,
            'status'     => 'inactive',
        ],
    ];

    /**
     * Mengambil seluruh data author.
     *
     * @return array
     */
    public function getAll()
    {
        return $this->authors;
    }

    /**
     * Mengambil satu data author berdasarkan ID.
     *
     * @param int $id
     * @return array|null
     */
    public function findById($id)
    {
        foreach ($this->authors as $author) {
            if ($author['id'] === $id) {
                return $author;
            }
        }
        return null;
    }
}