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
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::where('name', '!=', 'James Napone')->inRandomOrder()->first();
        $seat = StudySpace::inRandomOrder()->first();

        return [
            'user_id' => $user->id,
            'reserved_seat' => $seat->id,
            'reason' => $this->faker->sentence(4)
        ];
    }
}
