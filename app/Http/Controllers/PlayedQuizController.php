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
        return PlayedQuiz::create($request->all());
    }

    public function show(PlayedQuiz $PlayedQuiz)
    {
        return $PlayedQuiz;
    }

    public function update(Request $request, PlayedQuiz $PlayedQuiz)
    {
        $PlayedQuiz->update($request->all());
        return $PlayedQuiz;
    }

    public function destroy(PlayedQuiz $PlayedQuiz)
    {
        $PlayedQuiz->delete();
        return response()->noContent();
    }
}
