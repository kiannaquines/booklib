<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EquipmentReservation;

class EquipmentReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EquipmentReservation::create([
            'equipment_id' => 1,
            'user_id' => 1,
            'study_space_id' => 1,
            'start_time' => now(),
            'end_time' => now()->addDays(3),
        ]);

        EquipmentReservation::create([
            'equipment_id' => 2,
            'user_id' => 2,
            'study_space_id' => 2,
            'start_time' => now(),
            'end_time' => now()->addDays(3),
        ]);
    }
}
