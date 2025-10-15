<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Player>
 */
class PlayerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'wants_newsletter' => fake()->boolean(30), // 30% chance of wanting newsletter
            'join_link' => fake()->uuid()
        ];
    }

    /**
     * Indicate that the player wants newsletter.
     */
    public function wantsNewsletter(): static
    {
        return $this->state(fn (array $attributes) => [
            'wants_newsletter' => true,
        ]);
    }

    /**
     * Indicate that the player doesn't want newsletter.
     */
    public function noNewsletter(): static
    {
        return $this->state(fn (array $attributes) => [
            'wants_newsletter' => false,
        ]);
    }

    /**
     * Create a player without email (anonymous).
     */
    public function anonymous(): static
    {
        return $this->state(fn (array $attributes) => [
            'email' => null,
            'wants_newsletter' => false,
        ]);
    }
}
