<?php

namespace App\Http\Controllers;

use App\Http\Resources\InscriptionResource;
use App\Models\Formation;
use App\Models\Inscription;
use App\Policies\InscriptionPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InscriptionController extends Controller
{
    public function store(Request $request, Formation $formation){
        $user = Auth::user();

        $result = (new InscriptionPolicy)->create($user, $formation);

        if ($result !== true) {
            return response()->json(['message' => $result], 403);
        }

        $inscription = Inscription::create([
            'user_id' => $user->id,
            'formation_id' => $formation->id,
        ]);

        return new InscriptionResource($inscription);
    }

    public function index(Formation $formation)
    {
        $inscriptions = Inscription::where('formation_id', $formation->id)
            ->with('user:id,name,num_phone')
            ->get();

        return InscriptionResource::collection($inscriptions);
    }
}
