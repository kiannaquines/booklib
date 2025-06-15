<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Books;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Books::create([
            'title' => 'The Great Gatsby',
            'author' => 'F. Scott Fitzgerald',
            'status' => 'Available',
        ]);

        Books::create([
            'title' => 'The Little Prince',
            'author' => 'Antoine de Saint-Exupéry',
            'status' => 'Available',
        ]);

        Books::create([
            'title' => 'The Alchemist',
            'author' => 'Paulo Coelho',
            'status' => 'Available',
        ]);

        Books::create([
            'title' => 'The Catcher in the Rye',
            'author' => 'J.D. Salinger',
            'status' => 'Available',
        ]);

    }
}
