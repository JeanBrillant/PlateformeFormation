<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FormationResource extends JsonResource
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
            'titre' => $this->titre,
            'description' => $this->description,
            'centre_id' => $this->centre_id,
            'date_debut' => $this->date_debut,
            'date_fin' => $this->date_fin,
            'heure_debut' => $this->heure_debut,
            'nombre_place' => $this->nombre_place,
        ];
    }
}
