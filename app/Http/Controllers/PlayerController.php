<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function index()
    {
        return Player::all();
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
        return $Player;
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
        return response()->noContent();
    }

    public function playedQuizzes(Player $Player)
    {
        return $Player->playedQuizzes()->get();
    }
}
