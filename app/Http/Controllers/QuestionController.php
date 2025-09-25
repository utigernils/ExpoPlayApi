<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index()
    {
        return Question::all();
    }

    public function store(Request $request)
    {
        return Question::create($request->all());
    }

    public function show(Question $Question)
    {
        return $Question;
    }

    public function update(Request $request, Question $Question)
    {
        $Question->update($request->all());
        return $Question;
    }

    public function destroy(Question $Question)
    {
        $Question->delete();
        return response()->noContent();
    }
}
