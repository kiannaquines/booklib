<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Equipment;
use App\Models\StudySpace;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EquipmentReservation>
 */
class EquipmentReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::where('name', '!=', 'James Napone')->inRandomOrder()->first();
        $equipment = Equipment::inRandomOrder()->first();

        $year = now()->year;
        $startTime = $this->faker->dateTimeBetween("$year-01-01", "$year-12-31");
        $endTime = (clone $startTime)->modify('+3 days');

        return [
            'user_id' => $user->id,
            'equipment_id' => $equipment->id,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'status' => 'Pending',
            'created_at' => $startTime,
            'updated_at' => $endTime,
        ];
    }
}
