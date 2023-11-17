<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;

    protected $fillable = [
        'conversation_id',
        'body',
        'user_id',
    ];
    public function conversation(){
        return $this->belongsTo('App\Models\Conversation');
    }
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
