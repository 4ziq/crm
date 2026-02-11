<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'status' => $this->faker->randomElement(['open', 'in progress','resolved','closed']),
            'priority' => $this->faker->randomElement(['low', 'medium', 'high']),
            'customer_id' => \App\Models\Customer::factory(),
            'assigned_to' => \App\Models\User::factory(),
        ];
    }
}
