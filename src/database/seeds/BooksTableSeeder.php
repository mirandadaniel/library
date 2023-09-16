<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Book;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Book::create([
            'title' => 'Book 1 Title',
            'author' => 'Author 1',
        ]);

        Book::create([
            'title' => 'Book 2 Title',
            'author' => 'Author 2',
        ]);
    }
}
