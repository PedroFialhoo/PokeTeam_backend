<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pokemon extends Model
{
    protected $fillable = [
        'id',
        'id_pokemon',
    ];

    public function team(){
        return $this->belongsTo(Team::class);
    }
}
