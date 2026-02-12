<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Customer;
use App\Models\Interaction;
use App\Models\Ticket;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Symfony\Component\Console\Attribute\Interact;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
        ]);

        $admin->assignRole('admin');

        $support = User::create([
            'name' => 'Support',
            'email' => 'support@gmail.com',
            'password' => bcrypt('password'),
        ]);

        $support->assignRole('support');

        $user = User::create([
            'name' => 'User',
            'email' => 'user@gmail.com',
            'password' => bcrypt('password'),
        ]);

        $user->assignRole('user');

        Customer::factory()->count(50)->create();

        Interaction::factory()->count(50)->create();

        Ticket::factory(50)->create();
    }
}
