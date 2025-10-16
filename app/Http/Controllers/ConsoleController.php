<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreConsoleRequest;
use App\Http\Requests\UpdateConsoleRequest;
use App\Http\Resources\ConsoleResource;
use App\Http\Resources\ExpoResource;
use App\Http\Resources\QuizResource;
use App\Models\Console;
use Illuminate\Http\Request;

class ConsoleController extends Controller
{
    public function index()
    {
        return ConsoleResource::collection(Console::all());
    }

    public function store(StoreConsoleRequest $request)
    {
        return new ConsoleResource(Console::create($request->validated()));
    }

    public function show(Console $Console)
    {
        return new ConsoleResource($Console);
    }

    public function update(UpdateConsoleRequest $request, Console $Console)
    {
        $Console->update($request->validated());
        return new ConsoleResource($Console);
    }

    public function destroy(Console $Console)
    {
        $Console->delete();
        return response()->json(["message"=> "Console deleted successfully"], 200);
    }

    public function currentExpo(Console $Console)
    {
        return new ExpoResource($Console->currentExpo()->first());
    }

    public function currentQuiz(Console $Console)
    {
        return new QuizResource($Console->currentQuiz()->first());
    }
}
