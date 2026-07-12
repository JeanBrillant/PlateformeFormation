<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $guarded = [];

    // Proprietaire du role
    public function user(){
        return $this->belongsTo(User::class);
    }
}
