<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BookReservation;

class BookReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BookReservation::create([
            'user_id' => 1,
            'book_id' => 1,
            'study_space_id' => 1,
            'start_time' => now(),
            'end_time' => now()->addDays(3),
        ]);

        BookReservation::create([
            'user_id' => 2,
            'book_id' => 2,
            'study_space_id' => 2,
            'start_time' => now(),
            'end_time' => now()->addDays(3),
        ]);
    }
}
