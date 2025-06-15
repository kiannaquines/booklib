<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Equipment;

class EquipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Scientific Equipment
        Equipment::create([
            'name' => 'Microscope',
            'status' => 'Available',
        ]);

        Equipment::create([
            'name' => 'Spectrophotometer',
            'status' => 'Available',
        ]);

        Equipment::create([
            'name' => 'Balance',
            'status' => 'Available',
        ]);
    }
}
