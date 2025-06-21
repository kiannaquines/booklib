<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Books;
use App\Models\Equipment;
use App\Models\StudySpace;
use App\Models\EquipmentReservation;
use App\Models\BookReservation;
use Database\Factories\SeatReservationFactory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // Create roles
        $admin = Role::create(['name' => 'admin']);
        $user = Role::create(['name' => 'user']);

        // Books Permissions
        $addBooks = Permission::create(['name' => 'add-books']);
        $editBooks = Permission::create(['name' => 'edit-books']);
        $deleteBooks = Permission::create(['name' => 'delete-books']);

        // Equipment Permissions
        $addEquipment = Permission::create(['name' => 'add-equipment']);
        $editEquipment = Permission::create(['name' => 'edit-equipment']);
        $deleteEquipment = Permission::create(['name' => 'delete-equipment']);

        // Study Space Permissions
        $addStudySpace = Permission::create(['name' => 'add-study-space']);
        $editStudySpace = Permission::create(['name' => 'edit-study-space']);
        $deleteStudySpace = Permission::create(['name' => 'delete-study-space']);

        // Equipment Reservation Permissions
        $addEquipmentReservation = Permission::create(['name' => 'add-equipment-reservation']);
        $editEquipmentReservation = Permission::create(['name' => 'edit-equipment-reservation']);
        $deleteEquipmentReservation = Permission::create(['name' => 'delete-equipment-reservation']);

        // Book Reservation Permissions
        $addBookReservation = Permission::create(['name' => 'add-book-reservation']);
        $editBookReservation = Permission::create(['name' => 'edit-book-reservation']);
        $deleteBookReservation = Permission::create(['name' => 'delete-book-reservation']);

        // View Permissions
        $viewEquipmentReservation = Permission::create(['name' => 'view-equipment-reservation']);
        $viewBookReservation = Permission::create(['name' => 'view-book-reservation']);
        $viewEquipment = Permission::create(['name' => 'view-equipment']);
        $viewStudySpace = Permission::create(['name' => 'view-study-space']);

        // Books Permissions
        $admin->givePermissionTo($addBooks);
        $admin->givePermissionTo($editBooks);
        $admin->givePermissionTo($deleteBooks);

        // Equipment Permissions
        $admin->givePermissionTo($addEquipment);
        $admin->givePermissionTo($editEquipment);
        $admin->givePermissionTo($deleteEquipment);

        // Study Space Permissions
        $admin->givePermissionTo($addStudySpace);
        $admin->givePermissionTo($editStudySpace);
        $admin->givePermissionTo($deleteStudySpace);

        // Equipment Reservation Permissions
        $admin->givePermissionTo($addEquipmentReservation);
        $admin->givePermissionTo($editEquipmentReservation);
        $admin->givePermissionTo($deleteEquipmentReservation);

        // Book Reservation Permissions
        $admin->givePermissionTo($addBookReservation);
        $admin->givePermissionTo($editBookReservation);
        $admin->givePermissionTo($deleteBookReservation);

        // View Permissions
        $admin->givePermissionTo($viewEquipmentReservation);
        $admin->givePermissionTo($viewBookReservation);
        $admin->givePermissionTo($viewEquipment);
        $admin->givePermissionTo($viewStudySpace);

        User::factory(10)->create()->each(function ($user) {
            $user->assignRole('user');
        });

        User::factory()->create([
            'name' => 'James Napone',
            'email' => 'jamesnapone@gmail.com',
            'number' => '09123456789',
            'password' => Hash::make('password'),
        ])->assignRole('admin');

        Books::factory()->count(50)->create();

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

        EquipmentReservation::factory()->count(100)->create();
        BookReservation::factory()->count(100)->create();
    }
}
