<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePlayerRequest;
use App\Http\Resources\PlayerResource;
use App\Http\Resources\PlayedQuizResource;
use App\Models\Player;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function index()
    {
        return PlayerResource::collection(Player::all());
    }

    public function store(Request $request)
    {
        return response()->json([
            'message' => 'Player records cannot be created.',
            'error' => 'Method not allowed'
        ], 405);
    }

    public function show(Player $Player)
    {
        return new PlayerResource($Player);
    }

    public function update(Request $request, Player $Player)
    {
        return response()->json([
            'message' => 'Player records cannot be updated once created.',
            'error' => 'Method not allowed'
        ], 405);
    }

    public function destroy(Player $Player)
    {
        $Player->delete();
        return response()->json(["message"=> "Player deleted successfully"], 200);
    }

    public function playedQuizzes(Player $Player)
    {
        return new PlayedQuizResource($Player->playedQuizzes()->get());
    }
}
