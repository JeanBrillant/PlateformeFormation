<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFormationRequest;
use App\Models\Formation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FormationController extends Controller
{
    public function store(StoreFormationRequest $request){
        $validated = $request->validated();

        if(!Auth::user()->isAdminOf($validated['centre_id'])){
            return response()->json([
                'message' => 'Non autorisé, Vous etes pas l\'admin de ce Centre'
            ], 403);
        }

        $formation = Formation::create($validated);

        return response()->json([
            'data' => $formation,
        ], 201);
    }

    public function index(){
        return Formation::all();
    }
}
