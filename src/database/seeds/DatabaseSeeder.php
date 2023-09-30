<?php

use Illuminate\Database\Seeder;
use Database\Factories\BookFactory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        BookFactory::factory()->count(10)->create();
    }
}
