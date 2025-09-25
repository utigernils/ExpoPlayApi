<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index()
    {
        return Quiz::all();
    }

    public function store(Request $request)
    {
        return Quiz::create($request->all());
    }

    public function show(Quiz $Quiz)
    {        
        return $Quiz;
    }

    public function update(Request $request, Quiz $Quiz)
    {
        $Quiz->update($request->all());
        return $Quiz;
    }

    public function destroy(Quiz $Quiz)
    {
        $Quiz->delete();
        return response()->json(["message"=> "Quiz deleted successfully"], 200);
    }

    public function questions(Quiz $Quiz)
    {
        return $Quiz->questions()->get();
    }

    public function playedQuizzes(Quiz $Quiz)
    {
        return $Quiz->playedQuizzes()->get();
    }

    public function consoles(Quiz $Quiz)
    {
        return $Quiz->consoles()->get();
    }
}
