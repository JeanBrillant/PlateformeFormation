<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompteRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(StoreCompteRequest $request){
        $validated = $request->validated();

        $user = User::create($validated);

        return response()->json([
            'data' => $user
        ], 201);
    }

    public function getAllUsers(Request $request){
        $users = User::all();

        return response()->json([
            'data' => $users
        ], 200);
    } 
}
