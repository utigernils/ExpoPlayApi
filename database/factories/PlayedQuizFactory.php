<?php

namespace Database\Factories;

use App\Models\Expo;
use App\Models\Player;
use App\Models\Quiz;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PlayedQuiz>
 */
class PlayedQuizFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startedOn = fake()->dateTimeBetween('-3 months', 'now');
        $endedOn = fake()->optional(0.9)->dateTimeBetween($startedOn, 'now'); // 90% are completed
        
        $maxPoints = fake()->numberBetween(50, 500);
        $points = $endedOn ? fake()->numberBetween(0, $maxPoints) : 0;

        return [
            'player_id' => Player::factory(),
            'quiz_id' => Quiz::factory(),
            'expo_id' => Expo::factory(),
            'started_on' => $startedOn,
            'ended_on' => $endedOn,
            'points' => $points,
            'quiz_max_points' => $maxPoints,
            'quiz_name' => fake()->words(2, true) . ' Quiz',
            'expo_name' => fake()->words(2, true) . ' Expo',
        ];
    }

    /**
     * Indicate that the quiz is completed.
     */
    public function completed(): static
    {
        return $this->state(function (array $attributes) {
            $maxPoints = $attributes['quiz_max_points'] ?? fake()->numberBetween(50, 500);
            return [
                'ended_on' => fake()->dateTimeBetween($attributes['started_on'], 'now'),
                'points' => fake()->numberBetween(0, $maxPoints),
                'quiz_max_points' => $maxPoints,
            ];
        });
    }

    /**
     * Indicate that the quiz is still in progress.
     */
    public function inProgress(): static
    {
        return $this->state(fn (array $attributes) => [
            'ended_on' => null,
            'points' => 0,
        ]);
    }

    /**
     * Create a high-scoring played quiz.
     */
    public function highScore(): static
    {
        return $this->state(function (array $attributes) {
            $maxPoints = $attributes['quiz_max_points'] ?? fake()->numberBetween(50, 500);
            return [
                'points' => fake()->numberBetween((int)($maxPoints * 0.8), $maxPoints),
                'quiz_max_points' => $maxPoints,
            ];
        });
    }
}
