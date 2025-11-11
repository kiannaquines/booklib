<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\StudySpace;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SeatReservation>
 */
class SeatReservationFactory extends Factory
{
    private static $reasons = [
        'Individual study session',
        'Group project meeting',
        'Exam preparation',
        'Research work',
        'Reading assignment',
        'Thesis writing',
        'Online class attendance',
        'Assignment completion',
        'Study group discussion',
        'Quiet reading time',
    ];
    
    private static $reasonIndex = 0;
    
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::where('name', '!=', 'James Napone')->inRandomOrder()->first();
        $seat = StudySpace::inRandomOrder()->first();
        
        $reason = self::$reasons[self::$reasonIndex % count(self::$reasons)];
        self::$reasonIndex++;
        
        $startTime = $this->faker->dateTimeBetween('-30 days', 'now');
        $endTime = (clone $startTime)->modify('+2 hours'); // 2 hour max stay

        return [
            'user_id' => $user->id,
            'reserved_seat' => $seat->id,
            'reason' => $reason,
            'start_time' => $startTime,
            'end_time' => $endTime,
        ];
    }
}
