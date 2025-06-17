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
            'seat_number' => 'S101',
            'status' => 'Available',
        ]);

        StudySpace::create([
            'seat_number' => 'S102',
            'status' => 'Available',
        ]);

        StudySpace::create([
            'seat_number' => 'S103',
            'status' => 'Available',
        ]);

        StudySpace::create([
            'seat_number' => 'S104',
            'status' => 'Available',
        ]);

        StudySpace::create([
            'seat_number' => 'S105',
            'status' => 'Available',
        ]);

        StudySpace::create([
            'seat_number' => 'S106',
            'status' => 'Available',
        ]);

        StudySpace::create([
            'seat_number' => 'S106',
            'status' => 'Available',
        ]);

        StudySpace::create([
            'seat_number' => 'S107',
            'status' => 'Available',
        ]);

        StudySpace::create([
            'seat_number' => 'S108',
            'status' => 'Available',
        ]);

        StudySpace::create([
            'seat_number' => 'S109',
            'status' => 'Available',
        ]);

        StudySpace::create([
            'seat_number' => 'S110',
            'status' => 'Available',
        ]);

        StudySpace::create([
            'seat_number' => 'S111',
            'status' => 'Available',
        ]);

        StudySpace::create([
            'seat_number' => 'S112',
            'status' => 'Available',
        ]);
        
    }
}
