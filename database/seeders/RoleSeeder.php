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

        $editArticles = Permission::create(['name' => 'edit articles']);
        $deleteArticles = Permission::create(['name' => 'delete articles']);

        $admin->givePermissionTo($editArticles);
        $admin->givePermissionTo($deleteArticles);

        $user = User::find(1);
        $user->assignRole('admin');

        $user = User::find(2);
        $user->assignRole('user');
    }
}
