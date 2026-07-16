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
        $formation = Formation::find($validated['formation_id']);

        // Verification que l'utilisateur a le role "apprenant"
        if (!$user->hasRole('apprenant')){
            return response()->json([
                'message' => 'Seul un apprenant peut s\'inscrire aux formations'
            ], 403);
        }

        // Verification que l'utilisateur n'est pas deja inscit
        $dejaInscrit = Inscription::where('user_id', $user->id)->where('formation_id', $validated['formation_id'])->exists();

        if($dejaInscrit){
            return response()->json([
                'message' => 'Vous êtes déjà inscrit à cette formation'
            ], 409);
        }

        if ($user->isAdminOf($formation->centre_id)) {
            return response()->json([
                'message' => 'Un admin ne peut pas s\'inscrire à une formation de son propre centre'
            ], 403);
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
