<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Book;

class BookFactory extends Factory
{
    protected $model = Book::class;
    public function definition()
    {
        $titleWords = $this->faker->words(rand(3, 6)); 
        $title = implode(' ', $titleWords); 

        return [
            'title' => ucfirst($title), 
            'author' => $this->faker->name,
        ];
    }
}
