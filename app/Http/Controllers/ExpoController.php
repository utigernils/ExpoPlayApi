<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExpoRequest;
use App\Http\Requests\UpdateExpoRequest;
use App\Models\Expo;
use Illuminate\Http\Request;

class ExpoController extends Controller
{
    public function index()
    {
        return Expo::all();
    }

    public function store(StoreExpoRequest $request)
    {
        return Expo::create($request->validated());
    }

    public function show(Expo $Expo)
    {
        return $Expo;
    }

    public function update(UpdateExpoRequest $request, Expo $Expo)
    {
        $Expo->update($request->validated());
        return $Expo;
    }

    public function destroy(Expo $Expo)
    {
        $Expo->delete();
        return response()->json(["message"=> "Expo deleted successfully"], 200);
    }

    public function consoles(Expo $Expo)
    {
        return $Expo->consoles()->get();
    }

    public function playedQuizzes(Expo $Expo)
    {
        return $Expo->playedQuizzes()->get();
    }
}
