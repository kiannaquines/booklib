<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BookCategory;

class BookCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Fiction',
                'description' => 'Works of imaginative narration, including novels and short stories',
            ],
            [
                'name' => 'Non-Fiction',
                'description' => 'Factual books including biographies, history, and science',
            ],
            [
                'name' => 'Science Fiction',
                'description' => 'Speculative fiction dealing with futuristic concepts and technology',
            ],
            [
                'name' => 'Mystery',
                'description' => 'Fiction dealing with the solution of a crime or the unraveling of secrets',
            ],
            [
                'name' => 'Romance',
                'description' => 'Fiction focused on romantic love and relationships',
            ],
            [
                'name' => 'Biography',
                'description' => 'Detailed descriptions of a person\'s life',
            ],
            [
                'name' => 'History',
                'description' => 'Books about past events and historical periods',
            ],
            [
                'name' => 'Self-Help',
                'description' => 'Books designed to help readers solve personal problems',
            ],
            [
                'name' => 'Philosophy',
                'description' => 'Books exploring fundamental questions about existence, knowledge, and ethics',
            ],
            [
                'name' => 'Classic Literature',
                'description' => 'Timeless works of literature recognized for their artistic merit',
            ],
        ];

        foreach ($categories as $category) {
            BookCategory::create($category);
        }
    }
}
