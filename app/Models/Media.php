<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;
    // protected $fillable = [
    //     'url',
    //     'base_path',
    //     'description',
    //     'user_id',
    //     'file_size',
    //     'provider',
    // ];

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
}
