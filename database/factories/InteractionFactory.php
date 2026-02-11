<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Customer;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Interaction>
 */
class InteractionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_id' => Customer::factory(),
            'interaction_date' => $this->faker->dateTimeBetween('-1 years', 'now'),
            'type' => $this->faker->randomElement(['call', 'email', 'meeting']),
            'notes' => $this->faker->optional()->text(),
        ];
    }
}
