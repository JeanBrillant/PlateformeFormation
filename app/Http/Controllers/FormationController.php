<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFormationRequest;
use App\Http\Resources\FormationResource;
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

        return new FormationResource($formation);
    }

    public function index(){
        return FormationResource::collection(Formation::all());
    }
}
