<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Customer;
use App\Models\Interaction;
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

        // Customer::factory()->count(50)->create();


        Interaction::factory()->count(50)->create();
    }
}
