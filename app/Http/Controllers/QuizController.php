<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuizRequest;
use App\Http\Requests\UpdateQuizRequest;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index()
    {
        return Quiz::all();
    }

    public function store(StoreQuizRequest $request)
    {
        return Quiz::create($request->validated());
    }

    public function show(Quiz $Quiz)
    {        
        return $Quiz;
    }

    public function update(UpdateQuizRequest $request, Quiz $Quiz)
    {
        $Quiz->update($request->validated());
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
