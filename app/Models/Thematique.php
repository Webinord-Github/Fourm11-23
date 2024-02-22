<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thematique extends Model
{
    use HasFactory;

    public function conversations() {
        return $this->belongsToMany(Conversation::class);
    }

    public function posts() {
        return $this->belongsToMany(Post::class);
    }

    public function tools() {
        return $this->belongsToMany(Tool::class);
    }

    
    public function bookmarksThematiques()
    {
        return $this->hasMany(BookmarkThematiques::class);
    }
}
