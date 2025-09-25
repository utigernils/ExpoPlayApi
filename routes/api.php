<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    PlayerController,
    ExpoController,
    QuizController,
    ConsoleController,
    PlayedQuizController,
    QuestionController
};

Route::apiResources([
    'players' => PlayerController::class,
    'expos' => ExpoController::class,
    'quizzes' => QuizController::class,
    'consoles' => ConsoleController::class,
    'played-quizzes' => PlayedQuizController::class,
    'questions' => QuestionController::class,
]);


Route::get('consoles/{Console}/current-expo', [ConsoleController::class, 'currentExpo']);
Route::get('consoles/{Console}/current-quiz', [ConsoleController::class, 'currentQuiz']);

Route::get('expos/{Expo}/consoles', [ExpoController::class, 'consoles']);
Route::get('expos/{Expo}/played-quizzes', [ExpoController::class, 'playedQuizzes']);

Route::get('played-quizzes/{PlayedQuiz}/player', [PlayedQuizController::class, 'player']);
Route::get('played-quizzes/{PlayedQuiz}/quiz', [PlayedQuizController::class, 'quiz']);
Route::get('played-quizzes/{PlayedQuiz}/expo', [PlayedQuizController::class, 'expo']);

Route::get('players/{Player}/played-quizzes', [PlayerController::class, 'playedQuizzes']);

Route::get('questions/{Question}/quiz', [QuestionController::class,'quiz']);

Route::get('quizzes/{Quiz}/questions', [QuizController::class,'questions']);
Route::get('quizzes/{Quiz}/played-quizzes', [QuizController::class,'playedQuizzes']);
Route::get('quizzes/{Quiz}/consoles', [QuizController::class,'consoles']);
