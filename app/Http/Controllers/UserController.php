<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        return UserResource::collection(User::all());
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        $data = $request->validated();

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->fill($data)->save();

        return new UserResource($user);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->noContent();
    }
}
