<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Books;
use App\Models\StudySpace;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BookReservation>
 */
class BookReservationFactory extends Factory
{
    public function definition(): array
    {
        $user = User::where('id', '!=', 1)->inRandomOrder()->first();
        $book = Books::inRandomOrder()->first();
        $space = StudySpace::inRandomOrder()->first();

        if (!$user || !$book || !$space) {
            return [];
        }

        $year = now()->year;
        $startTime = $this->faker->dateTimeBetween("$year-01-01", "$year-12-31");
        $endTime = (clone $startTime)->modify('+3 days');

        return [
            'user_id' => $user->id,
            'book_id' => $book->id,
            'study_space_id' => $space->id,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'created_at' => $startTime,
            'updated_at' => $endTime,
        ];
    }
}
