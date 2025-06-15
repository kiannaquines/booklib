<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StudySpace;

class StudySpaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StudySpace::create([
            'seat_number' => '101',
            'status' => 'Available',
        ]);

        StudySpace::create([
            'seat_number' => '102',
            'status' => 'Available',
        ]);

        StudySpace::create([
            'seat_number' => '103',
            'status' => 'Available',
        ]);

        StudySpace::create([
            'seat_number' => '104',
            'status' => 'Available',
        ]);

        StudySpace::create([
            'seat_number' => '105',
            'status' => 'Available',
        ]);

        StudySpace::create([
            'seat_number' => '106',
            'status' => 'Available',
        ]);
    }
}
