<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Author;
use App\Models\Genre;
use App\Models\Book;

class BookTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Book::factory()
            ->has(Author::factory()->count(1))
            ->has(Genre::factory()->count(1))
            ->count(10)
            ->create();
    }
}
