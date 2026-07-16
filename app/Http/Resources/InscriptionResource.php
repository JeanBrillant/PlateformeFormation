<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InscriptionResource extends JsonResource
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
            'user_id' => $this->user_id,
            'formation_id' => $this->formation_id,
            'date_inscription' => $this->date_inscription,
            'user' => [
                'id' => $this->user->id,
                'nom' => $this->user->name,
                'phone' => $this->user->num_phone,
            ]
        ];
    }
}
