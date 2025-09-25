<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreConsoleRequest;
use App\Http\Requests\UpdateConsoleRequest;
use App\Models\Console;
use Illuminate\Http\Request;

class ConsoleController extends Controller
{
    public function index()
    {
        return Console::all();
    }

    public function store(StoreConsoleRequest $request)
    {
        return Console::create($request->validated());
    }

    public function show(Console $Console)
    {
        return $Console;
    }

    public function update(UpdateConsoleRequest $request, Console $Console)
    {
        $Console->update($request->validated());
        return $Console;
    }

    public function destroy(Console $Console)
    {
        $Console->delete();
        return response()->json(["message"=> "Console deleted successfully"], 200);
    }

    public function currentExpo(Console $Console)
    {
        return $Console->currentExpo()->first();
    }

    public function currentQuiz(Console $Console)
    {
        return $Console->currentQuiz()->first();
    }
}
