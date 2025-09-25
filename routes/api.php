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