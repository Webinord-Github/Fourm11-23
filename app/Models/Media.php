<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'path',
        'name',
        'original_name',
        'alt',
        'size',
        'provider',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function fact(){
        return $this->hasMany(Fact::class);
    }

    public function tool(){
        return $this->hasMany(Tool::class);
    }

    public function post(){
        return $this->hasMany(Post::class);
    }
    public function events()
    {
        return $this->hasMany(Event::class, 'image_id');
    }
    public function profilePics()
    {
        return $this->hasMany(User::class);
    }
}
