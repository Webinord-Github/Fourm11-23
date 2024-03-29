<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tool extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function media(){
        return $this->belongsTo(Media::class);
    }

    public function thematiques() {
        return $this->belongsToMany(Thematique::class);
    }

    public function signets(){
        return $this->hasMany(Signet::class);
    }
}
