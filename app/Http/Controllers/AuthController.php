<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request){
        $validated = $request->validate([
            'name' => 'required',
            'num_phone' => 'required|min:10|max:10|unique',
            'firtname' => 'nullable',
            'password' => 'required|min:6',
            'password_confirmation' => 'required',
        ]);

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
