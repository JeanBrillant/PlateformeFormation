<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInscriptionRequest;
use App\Http\Resources\InscriptionResource;
use App\Models\Formation;
use App\Models\Inscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InscriptionController extends Controller
{
    public function store(StoreInscriptionRequest $request){
        $validated = $request->validated();
        $user = Auth::user();
        $formation = Formation::findOrFail($validated['formation_id']);

        $result = (new \App\Policies\InscriptionPolicy)->create($user, $formation);

        if ($result !== true) {
            return response()->json(['message' => $result], 403);
        }

        $inscription = Inscription::create([
            'user_id' => $user->id,
            'formation_id' => $validated['formation_id'],
        ]);

        return new InscriptionResource($inscription);
    }

    public function index(Formation $formation)
    {
        $inscriptions = Inscription::where('formation_id', $formation->id)->with('user:id,name,num_phone')->get();

        return InscriptionResource::collection($inscriptions);
    }
}
