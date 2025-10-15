<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\NeedsAdminRights;

use App\Http\Controllers\{
    AuthController,
    PlayerController,
    ExpoController,
    QuizController,
    ConsoleController,
    PlayedQuizController,
    QuestionController
};

// Public authentication routes
Route::post('login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Authentication routes
    Route::middleware(NeedsAdminRights::class)->post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('logout-all', [AuthController::class, 'logoutAll']);
    Route::get('user', [AuthController::class, 'user']);

    // API Resources (admin only)
    Route::apiResources([
        'players' => PlayerController::class,
        'expos' => ExpoController::class,
        'quizzes' => QuizController::class,
        'consoles' => ConsoleController::class,
        'played-quizzes' => PlayedQuizController::class,
        'questions' => QuestionController::class,
    ]);

    // Custom routes
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
});
