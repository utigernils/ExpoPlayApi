<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExpoRequest;
use App\Http\Requests\UpdateExpoRequest;
use App\Http\Resources\ExpoResource;
use App\Models\Expo;
use Illuminate\Http\Request;

class ExpoController extends Controller
{
    public function index()
    {
        return ExpoResource::collection(Expo::all() );
    }

    public function store(StoreExpoRequest $request)
    {
        return new ExpoResource(Expo::create($request->validated()));
    }

    public function show(Expo $Expo)
    {
        return new ExpoResource($Expo);
    }

    public function update(UpdateExpoRequest $request, Expo $Expo)
    {
        $Expo->update($request->validated());
        return new ExpoResource($Expo);
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
