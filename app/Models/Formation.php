<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Formation extends Model
{
    protected $guarded = [];

    public function centre():BelongsTo{
        return $this->belongsTo(Centre::class);
    }
}
