<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index()
    {
        return Question::all();
    }

    public function store(StoreQuestionRequest $request)
    {
        return Question::create($request->validated());
    }

    public function show(Question $Question)
    {
        return $Question;
    }

    public function update(UpdateQuestionRequest $request, Question $Question)
    {
        $Question->update($request->validated());
        return $Question;
    }

    public function destroy(Question $Question)
    {
        $Question->delete();
        return response()->json(["message"=> "Question deleted successfully"], 200);
    }

    public function quiz(Question $Question)
    {
        return $Question->quiz()->first();
    }
}
