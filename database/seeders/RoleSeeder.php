<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
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
    }
}
