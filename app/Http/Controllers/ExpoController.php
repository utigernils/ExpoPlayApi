<?php

namespace App\Http\Controllers;

use App\Models\Expo;
use Illuminate\Http\Request;

class ExpoController extends Controller
{
    public function index()
    {
        return Expo::all();
    }

    public function store(Request $request)
    {
        return Expo::create($request->all());
    }

    public function show(Expo $Expo)
    {
        return $Expo;
    }

    public function update(Request $request, Expo $Expo)
    {
        $Expo->update($request->all());
        return $Expo;
    }

    public function destroy(Expo $Expo)
    {
        $Expo->delete();
        return response()->noContent();
    }
}
