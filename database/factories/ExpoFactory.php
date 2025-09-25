<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Expo>
 */
class ExpoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = fake()->dateTimeBetween('-6 months', '+6 months');
        $endDate = fake()->dateTimeBetween($startDate, '+1 year');

        return [
            'name' => fake()->words(2, true) . ' Expo',
            'introduction_title' => fake()->sentence(4, false),
            'introduction_subtitle' => fake()->optional(0.8)->paragraph(2),
            'location' => fake()->city() . ', ' . fake()->country(),
            'starts_on' => $startDate->format('Y-m-d'),
            'ends_on' => $endDate->format('Y-m-d'),
        ];
    }

    /**
     * Indicate that the expo is currently running.
     */
    public function running(): static
    {
        return $this->state(fn (array $attributes) => [
            'starts_on' => now()->subDays(rand(1, 30))->format('Y-m-d'),
            'ends_on' => now()->addDays(rand(1, 60))->format('Y-m-d'),
        ]);
    }

    /**
     * Indicate that the expo is upcoming.
     */
    public function upcoming(): static
    {
        return $this->state(fn (array $attributes) => [
            'starts_on' => now()->addDays(rand(1, 90))->format('Y-m-d'),
            'ends_on' => now()->addDays(rand(91, 180))->format('Y-m-d'),
        ]);
    }
}
