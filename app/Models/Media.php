<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;
    protected $fillable = [
        'url',
        'base_path',
        'description',
        'user_id',
        'file_size',
        'provider',
    ];

    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
