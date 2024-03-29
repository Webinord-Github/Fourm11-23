<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function thematiques() {
        return $this->belongsToMany(Thematique::class);
    }

    public function media(){
        return $this->belongsTo(Media::class, 'image_id');
    }
    
    public function postmarks()
    {
        return $this->hasMany(Postmark::class);
    }
}
