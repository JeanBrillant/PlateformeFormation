<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Formation extends Model
{
    protected $guarded = [];

    public function centre():BelongsTo{
        return $this->belongsTo(Centre::class);
    }

    public function inscriptions():HasMany{
        return $this->hasMany(Inscription::class);
    }
}
