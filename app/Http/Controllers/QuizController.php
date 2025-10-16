<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuizRequest;
use App\Http\Requests\UpdateQuizRequest;
use App\Http\Resources\QuizResource;
use App\Http\Resources\QuestionResource;
use App\Http\Resources\PlayedQuizResource;
use App\Http\Resources\ConsoleResource;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index()
    {
        return QuizResource::collection(Quiz::all());
    }

    public function store(StoreQuizRequest $request)
    {
        return new QuizResource(Quiz::create($request->validated()));
    }

    public function show(Quiz $Quiz)
    {
        return new QuizResource($Quiz);
    }

    public function update(UpdateQuizRequest $request, Quiz $Quiz)
    {
        $Quiz->update($request->validated());
        return new QuizResource($Quiz);
    }

    public function destroy(Quiz $Quiz)
    {
        $Quiz->delete();
        return response()->json(["message"=> "Quiz deleted successfully"], 200);
    }

    public function questions(Quiz $Quiz)
    {
        return QuestionResource::collection($Quiz->questions()->get());
    }

    public function playedQuizzes(Quiz $Quiz)
    {
        return PlayedQuizResource::collection($Quiz->playedQuizzes()->get());
    }

    public function consoles(Quiz $Quiz)
    {
        return ConsoleResource::collection($Quiz->consoles()->get());
    }
}
