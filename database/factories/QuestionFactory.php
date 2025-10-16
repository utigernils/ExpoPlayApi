<?php

namespace Database\Factories;

use App\Models\Quiz;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $questionTypes = [1, 2, 3]; // Assuming different question types
        $questionType = fake()->randomElement($questionTypes);
        
        return [
            'quiz_id' => Quiz::factory(),
            'question' => fake()->sentence(rand(6, 12), false) . '?',
            'question_type' => $questionType,
            'answer_possibilities' => $this->generateAnswerPossibilities($questionType),
            'points' => fake()->numberBetween(5, 50),
            'is_hidden' => fake()->boolean(10), // 10% chance of being hidden
        ];
    }

    /**
     * Generate answer possibilities based on question type.
     */
    private function generateAnswerPossibilities(int $questionType): array
    {
        switch ($questionType) {
            case 1: // Multiple choice
                return [
                    'options' => [
                        fake()->sentence(3),
                        fake()->sentence(3),
                        fake()->sentence(3),
                        fake()->sentence(3),
                    ],
                    'correct' => fake()->numberBetween(0, 3),
                ];
            case 2: // True/False
                return [
                    'options' => ['True', 'False'],
                    'correct' => fake()->numberBetween(0, 1),
                ];
            case 3: // Text input
                return [
                    'correct_answers' => [
                        fake()->word(),
                        fake()->optional()->word(),
                    ],
                ];
            default:
                return [];
        }
    }

    /**
     * Create a multiple choice question.
     */
    public function multipleChoice(): static
    {
        return $this->state(fn (array $attributes) => [
            'question_type' => 1,
            'answer_possibilities' => [
                'options' => [
                    fake()->sentence(3),
                    fake()->sentence(3),
                    fake()->sentence(3),
                    fake()->sentence(3),
                ],
                'correct' => fake()->numberBetween(0, 3),
            ],
        ]);
    }

    /**
     * Create a true/false question.
     */
    public function trueFalse(): static
    {
        return $this->state(fn (array $attributes) => [
            'question_type' => 2,
            'answer_possibilities' => [
                'options' => ['True', 'False'],
                'correct' => fake()->numberBetween(0, 1),
            ],
        ]);
    }

    /**
     * Create a text input question.
     */
    public function textInput(): static
    {
        return $this->state(fn (array $attributes) => [
            'question_type' => 3,
            'answer_possibilities' => [
                'correct_answers' => [
                    fake()->word(),
                    fake()->optional()->word(),
                ],
            ],
        ]);
    }

    /**
     * Create a hidden question.
     */
    public function hidden(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_hidden' => true,
        ]);
    }

    /**
     * Create a visible question.
     */
    public function visible(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_hidden' => false,
        ]);
    }
}
