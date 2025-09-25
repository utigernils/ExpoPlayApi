<?php

namespace App\Http\Controllers;

use App\Models\Console;
use Illuminate\Http\Request;

class ConsoleController extends Controller
{
    public function index()
    {
        return Console::all();
    }

    public function store(Request $request)
    {
        return Console::create($request->all());
    }

    public function show(Console $Console)
    {
        return $Console;
    }

    public function update(Request $request, Console $Console)
    {
        $Console->update($request->all());
        return $Console;
    }

    public function destroy(Console $Console)
    {
        $Console->delete();
        return response()->noContent();
    }
}
