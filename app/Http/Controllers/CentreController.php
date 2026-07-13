<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCentreRequest;
use App\Http\Resources\CentreResource;
use App\Models\Centre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Ramsey\Collection\Collection;

class CentreController extends Controller
{
    public function store(StoreCentreRequest $request){
        $validated = $request->validated();

        $validated['cree_par_id'] = Auth::user()->id;

        $centre = Centre::create($validated)->fresh();

        return new CentreResource($centre);
    }

    public function validate(Centre $centre, Request $request){
        if(!Auth::user()->hasRole('super_admin')){
            return response()->json(['message' => 'Non autorisé'], 403);
        }

        $centre->update([
            'statut' => 'valide',
            'valide_par_id' => Auth::user()->id,
            'date_validation' => now(),
        ]);

        $centre->creePar->roles()->create(['type' => 'admin']);

        return new CentreResource($centre);
    }

//     public function show(){
//         return new CentreResource(Centre::find(2));
//     }
// }
