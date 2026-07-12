<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreCompteRequest;
use App\Http\Resources\CompteCollection;
use App\Http\Resources\CompteResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(StoreCompteRequest $request){
        $validated = $request->validated();

        $validated['password'] = Hash::make($validated['password']);

        $roles = $validated['roles'];
        unset($validated['roles']);

        $user = User::create($validated);

        foreach ($roles as $role){
            $user->roles()->create(['type' => $role]);
        }

        return new CompteResource($user);
    }

    public function login(LoginRequest $request){
        $validated = $request->validated();

        $user = User::where('num_phone', $validated['num_phone'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)){
            return response()->json([
                'message' => 'Verifiez vos identifiants',
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'data' => $user->load('roles'),
            'token' => $token,
        ]);
    }

    public function getAllUsers(Request $request){
        $users = User::all();

        return new CompteCollection((User::all()));
    } 
}
