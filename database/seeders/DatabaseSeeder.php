<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Expo;
use App\Models\Quiz;
use App\Models\Console;
use App\Models\Player;
use App\Models\Question;
use App\Models\PlayedQuiz;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a test user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Create some expos
        $expos = Expo::factory(5)->create();
        
        // Create some quizzes
        $quizzes = Quiz::factory(10)->create();
        
        // Create questions for each quiz
        $quizzes->each(function ($quiz) {
            Question::factory(rand(5, 15))->create([
                'quiz_id' => $quiz->id,
            ]);
        });
        
        // Create some players
        $players = Player::factory(50)->create();
        
        // Create consoles (some with current expo/quiz, some without)
        Console::factory(8)->create();
        Console::factory(3)->withExpoAndQuiz()->active()->create();
        
        // Create played quizzes with relationships
        $players->each(function ($player) use ($quizzes, $expos) {
            // Some players played multiple quizzes
            $numQuizzesPlayed = rand(1, 5);
            
            for ($i = 0; $i < $numQuizzesPlayed; $i++) {
                $quiz = $quizzes->random();
                $expo = $expos->random();
                
                PlayedQuiz::factory()->create([
                    'player_id' => $player->id,
                    'quiz_id' => $quiz->id,
                    'expo_id' => $expo->id,
                    'quiz_name' => $quiz->name,
                    'expo_name' => $expo->name,
                ]);
            }
        });
        
        // Create some in-progress quizzes
        PlayedQuiz::factory(10)->inProgress()->create();
        
        // Create some high-scoring quizzes
        PlayedQuiz::factory(15)->completed()->highScore()->create();
    }
}
