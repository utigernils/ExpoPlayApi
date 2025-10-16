<?php

namespace Database\Factories;

use App\Models\Expo;
use App\Models\Quiz;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Console>
 */
class ConsoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'current_expo_id' => fake()->optional(0.8)->passthrough(Expo::factory()),
            'current_quiz_id' => fake()->optional(0.8)->passthrough(Quiz::factory()),
            'name' => 'Console ' . fake()->randomNumber(3),
            'is_active' => fake()->boolean(60), // 60% chance of being active
        ];
    }

    /**
     * Indicate that the console is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
        ]);
    }

    /**
     * Indicate that the console is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    /**
     * Configure the console for a specific expo and quiz.
     */
    public function withExpoAndQuiz($expoId = null, $quizId = null): static
    {
        return $this->state(fn (array $attributes) => [
            'current_expo_id' => $expoId ?? Expo::factory(),
            'current_quiz_id' => $quizId ?? Quiz::factory(),
        ]);
    }
}
