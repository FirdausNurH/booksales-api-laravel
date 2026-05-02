<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Author;
use App\Models\Book;

class BookAuthorSeeder extends Seeder {
    public function run(): void {
        $author1 = Author::create(['name' => 'J.K. Rowling', 'email' => 'jk@example.com', 'bio' => 'Penulis Harry Potter']);
        $author2 = Author::create(['name' => 'George R.R. Martin', 'email' => 'grrm@example.com', 'bio' => 'Penulis Game of Thrones']);
        $author3 = Author::create(['name' => 'Agatha Christie', 'email' => 'agatha@example.com', 'bio' => 'Ratu Misteri']);
        $author4 = Author::create(['name' => 'Stephen King', 'email' => 'king@example.com', 'bio' => 'Master Horror']);
        $author5 = Author::create(['name' => 'Tolkien', 'email' => 'tolkien@example.com', 'bio' => 'Pencipta Middle-earth']);

        Book::create(['title' => 'Harry Potter and the Philosopher\'s Stone', 'description' => 'Buku pertama seri HP', 'year_published' => 1997, 'author_id' => $author1->id]);
        Book::create(['title' => 'A Game of Thrones', 'description' => 'Buku pertama ASOIAF', 'year_published' => 1996, 'author_id' => $author2->id]);
        Book::create(['title' => 'Murder on the Orient Express', 'description' => 'Kisah misteri klasik', 'year_published' => 1934, 'author_id' => $author3->id]);
        Book::create(['title' => 'The Shining', 'description' => 'Novel horor ikonik', 'year_published' => 1977, 'author_id' => $author4->id]);
        Book::create(['title' => 'The Hobbit', 'description' => 'Petualangan Bilbo Baggins', 'year_published' => 1937, 'author_id' => $author5->id]);
    }
}