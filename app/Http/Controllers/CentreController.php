<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCentreRequest;
use App\Http\Resources\CentreResource;
use App\Models\Centre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CentreController extends Controller
{
    public function store(StoreCentreRequest $request){
        $validated = $request->validated();

        $validated['cree_par_id'] = Auth::user()->id;

        $centre = Centre::create($validated)->fresh();

        return new CentreResource($centre);
    }
}
