<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    public function run(): void
    {
        $genres = [
            ['name' => 'Fiksi', 'description' => 'Cerita yang dibuat berdasarkan imajinasi penulis, bukan berdasarkan fakta nyata.'],
            ['name' => 'Non-Fiksi', 'description' => 'Buku yang berisi fakta, informasi nyata, atau pengetahuan tertentu.'],
            ['name' => 'Sejarah', 'description' => 'Buku yang membahas peristiwa masa lalu secara kronologis dan faktual.'],
            ['name' => 'Romantis', 'description' => 'Genre yang berfokus pada kisah cinta dan hubungan antar karakter.'],
            ['name' => 'Fantasi', 'description' => 'Cerita dengan setting dunia magic, makhluk fiksi, dan kekuatan supernatural.'],
            ['name' => 'Biografi', 'description' => 'Buku yang menceritakan perjalanan hidup seseorang secara faktual.'],
            ['name' => 'Pendidikan', 'description' => 'Buku pelajaran atau referensi yang bertujuan untuk menambah pengetahuan pembaca.'],
            ['name' => 'Misteri', 'description' => 'Genre yang menampilkan teka-teki, kriminalitas, dan proses investigasi untuk menemukan jawabannya.'],
        ];

        foreach ($genres as $genre) {
            Genre::create($genre);
        }
    }
}