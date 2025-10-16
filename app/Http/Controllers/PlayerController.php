<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlayerJoinRequest;
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

    public function join(PlayerJoinRequest $request)
    {
        $player = Player::firstWhere('email', $request->input('email'));

        if (!$player) {
            $player = Player::create($request->validated());
        } else {
            $player->update($request->validated());
        }

        return response()->json([
            'message' => 'Player joined successfully.',
            'error' => null
        ], 200);
    }

    public function destroy(Player $Player)
    {
        $Player->delete();
        return response()->json(["message"=> "Player deleted successfully"], 200);
    }

    public function playedQuizzes(Player $Player)
    {
        return PlayedQuizResource::collection($Player->playedQuizzes()->get());
    }
}
