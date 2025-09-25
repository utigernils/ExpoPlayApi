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
        return Player::create($request->all());
    }

    public function show(Player $Player)
    {
        return $Player;
    }

    public function update(Request $request, Player $Player)
    {
        $Player->update($request->all());
        return $Player;
    }

    public function destroy(Player $Player)
    {
        $Player->delete();
        return response()->noContent();
    }
}
