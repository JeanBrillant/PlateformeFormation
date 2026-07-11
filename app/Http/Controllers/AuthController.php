<?php

namespace App\Http\Controllers;

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

        $user = User::create($validated);

        return new CompteResource($user);
    }

    public function getAllUsers(Request $request){
        $users = User::all();

        return new CompteCollection((User::all()));
    } 
}
