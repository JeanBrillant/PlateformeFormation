<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CentreResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nom_centre' => $this->nom_centre,
            'ville_centre' => $this->ville_centre,
            'quartier_centre' => $this->quartier_centre,
            'statut' => $this->statut,
        ];
    }
}
