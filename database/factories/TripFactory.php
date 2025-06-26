<?php

namespace Database\Factories;

use App\Models\Trip;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Trip>
 */
class TripFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = fake()->dateTimeBetween('now', '+1 month');
        $endDate = fake()->dateTimeBetween($startDate, $startDate->format('Y-m-d') . ' +2 weeks');

        return [
            'user_id' => User::factory(),
            'name' => fake()->sentence(3),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'destination' => fake()->city() . ', ' . fake()->country(),
            'travelers' => fake()->numberBetween(1, 8),
            'budget' => fake()->randomFloat(2, 500, 5000),
            'itinerary' => null,
            'accommodations' => null,
            'transportation' => null,
            'expenses' => null,
            'packing_list' => null,
            'notes' => fake()->optional()->paragraph(),
            'is_public' => fake()->boolean(20), // 20% chance of being public
            'collaborators' => null,
        ];
    }

    /**
     * Indicate that the trip should be public.
     */
    public function public(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_public' => true,
        ]);
    }

    /**
     * Indicate that the trip should be private.
     */
    public function private(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_public' => false,
        ]);
    }
}
