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
    private static $statuses = ['Pending', 'Approved', 'Rejected'];
    private static $statusIndex = 0;
    
    public function definition(): array
    {
        $user = User::where('name', '!=', 'James Napone')->inRandomOrder()->first();
        $book = Books::inRandomOrder()->first();

        if (!$user || !$book) {
            return [];
        }

        $year = now()->year;
        // Create dates within the current year
        $startTime = $this->faker->dateTimeBetween("$year-01-01", "$year-12-31");
        $endTime = (clone $startTime)->modify('+3 days');
        
        $status = self::$statuses[self::$statusIndex % count(self::$statuses)];
        self::$statusIndex++;

        return [
            'user_id' => $user->id,
            'book_id' => $book->id,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'status' => $status,
            'created_at' => $startTime,
            'updated_at' => $endTime,
        ];
    }
}
