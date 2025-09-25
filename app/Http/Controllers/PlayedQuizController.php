<?php

namespace App\Http\Controllers;

use App\Models\PlayedQuiz;
use Illuminate\Http\Request;

class PlayedQuizController extends Controller
{
        public function index()
    {
        return PlayedQuiz::all();
    }

    public function store(Request $request)
    {
        return response()->json([
            'message' => 'PlayedQuiz records cannot be created.',
            'error' => 'Method not allowed'
        ], 405);
    }

    public function show(PlayedQuiz $PlayedQuiz)
    {
        return $PlayedQuiz;
    }

    public function update(Request $request, PlayedQuiz $PlayedQuiz)
    {
        return response()->json([
            'message' => 'PlayedQuiz records cannot be updated once created.',
            'error' => 'Method not allowed'
        ], 405);
    }

    public function destroy(PlayedQuiz $PlayedQuiz)
    {
        $PlayedQuiz->delete();
        return response()->noContent();
    }

    public function player(PlayedQuiz $PlayedQuiz)
    {
        return $PlayedQuiz->player()->first();
    }

    public function quiz(PlayedQuiz $PlayedQuiz)
    {
        return $PlayedQuiz->quiz()->first();
    }

    public function expo(PlayedQuiz $PlayedQuiz)
    {
        return $PlayedQuiz->expo()->first();
    }
}
