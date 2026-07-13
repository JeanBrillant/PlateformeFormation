<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Centre extends Model
{
    protected $guarded = [];

    // Recuperation de celui qui a fait la demande de la creation du Centre
    public function creePar(): BelongsTo{
        return $this->belongsTo(User::class, 'cree_par_id');
    }
    
    // Recuperation du SuperAdmin
    public function validePar(): BelongsTo{
        return $this->belongsTo(User::class, 'valide_par_id');
    }
}
