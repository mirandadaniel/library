<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Book;

class BookFactory extends Factory
{
    protected $model = Book::class;
    public function definition()
    {
        $titleWords = $this->faker->words(rand(3, 6)); // Generate an array of random words for the title
        $title = implode(' ', $titleWords); // Join the words into a sentence-like format

        return [
            'title' => ucfirst($title), // Capitalize the first word
            'author' => $this->faker->name,
        ];
    }
}
