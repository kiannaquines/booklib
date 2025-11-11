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
        $equipments = [
            [
                'name' => 'Laptop - Dell XPS 15',
                'description' => 'High-performance laptop with Intel Core i7 processor, 16GB RAM, and 512GB SSD. Perfect for coding, research, and multimedia projects. Features a 15.6-inch 4K display.',
                'status' => 'Available',
            ],
            [
                'name' => 'Microscope - Olympus CX23',
                'description' => 'Professional biological microscope with LED illumination and multiple magnification levels (40x-1000x). Ideal for laboratory work and scientific research.',
                'status' => 'Available',
            ],
            [
                'name' => 'iPad Pro 12.9"',
                'description' => 'Latest generation tablet with Apple Pencil support. Excellent for digital note-taking, design work, and reading digital textbooks. Includes keyboard case.',
                'status' => 'Available',
            ],
            [
                'name' => 'Digital Camera - Canon EOS R6',
                'description' => 'Professional mirrorless camera with 20MP sensor and 4K video recording. Perfect for photography projects, journalism, and multimedia assignments. Includes 24-105mm lens.',
                'status' => 'Available',
            ],
            [
                'name' => 'Scientific Calculator - TI-84 Plus',
                'description' => 'Graphing calculator approved for standardized tests. Essential for advanced mathematics, statistics, and engineering courses. Pre-loaded with essential apps.',
                'status' => 'Available',
            ],
            [
                'name' => 'Portable Projector - Epson',
                'description' => 'Compact HD projector for presentations and group study sessions. Wireless connectivity and built-in speakers. Brightness: 3000 lumens.',
                'status' => 'Available',
            ],
            [
                'name' => 'Audio Recorder - Zoom H5',
                'description' => 'Professional portable audio recorder for interviews, podcasts, and music recording. Features 4-track recording and interchangeable microphone capsules.',
                'status' => 'Unavailable',
            ],
            [
                'name' => 'VR Headset - Meta Quest 3',
                'description' => 'Virtual reality headset for immersive learning experiences. Useful for architecture, design, and virtual field trips. Includes controllers and charging cable.',
                'status' => 'Available',
            ],
            [
                'name' => 'Drawing Tablet - Wacom Intuos Pro',
                'description' => 'Professional graphics tablet with pressure-sensitive stylus. Ideal for digital art, graphic design, and illustration projects. Compatible with major design software.',
                'status' => 'Available',
            ],
            [
                'name' => 'Drone - DJI Mini 3 Pro',
                'description' => 'Compact drone with 4K camera for aerial photography and videography. Perfect for geography, environmental studies, and media projects. Flight time: 30 minutes.',
                'status' => 'Available',
            ],
            [
                'name' => '3D Printer - Creality Ender 3',
                'description' => 'Entry-level 3D printer for prototyping and creative projects. Supports various filament types. Great for engineering, design, and maker projects.',
                'status' => 'Available',
            ],
            [
                'name' => 'Telescope - Celestron NexStar',
                'description' => 'Computerized telescope with automatic tracking for astronomy observations. Includes eyepieces and finder scope. Perfect for astrophysics and astronomy classes.',
                'status' => 'Available',
            ],
            [
                'name' => 'External Hard Drive - 2TB',
                'description' => 'High-capacity portable storage device for backing up large files and projects. USB 3.0 for fast data transfer. Includes protective case.',
                'status' => 'Available',
            ],
            [
                'name' => 'Wireless Headphones - Sony WH-1000XM5',
                'description' => 'Noise-canceling headphones for focused study sessions. Excellent audio quality for language learning and multimedia courses. Battery life: 30 hours.',
                'status' => 'Available',
            ],
            [
                'name' => 'Portable WiFi Hotspot',
                'description' => 'Mobile internet device for reliable connectivity anywhere on campus. Supports up to 10 devices simultaneously. Includes unlimited data plan.',
                'status' => 'Unavailable',
            ],
        ];

        foreach ($equipments as $equipment) {
            Equipment::create(array_merge($equipment, [
                'max_slots' => 25,
                'reserved_today' => 0,
                'last_reset_date' => now()->toDateString(),
                'total_quantity' => 25,
                'available_quantity' => 25,
            ]));
        }
    }
}
