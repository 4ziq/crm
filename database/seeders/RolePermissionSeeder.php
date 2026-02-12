<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Permissions 
        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'view reports']);
        Permission::create(['name' => 'manage tickets']);
        Permission::create(['name' => 'manage customers']);

        // Create Roles 
        $admin = Role::create(['name' => 'admin']);
        $user = Role::create(['name' => 'user']);
        $support = Role::create(['name' => 'support']);

        // Assign Permissions 
        $admin->givePermissionTo(Permission::all());
        $user->givePermissionTo(['manage customers']);
        $support->givePermissionTo(['manage tickets','view reports']);
    }
}