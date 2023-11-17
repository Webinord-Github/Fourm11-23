<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    protected $fillable = [
        'user1_id',
        'user2_id',
        'chat_id',
    ];
    public function user1()
    {
        return $this->belongsTo('App\Models\User', 'user1_id');
    }
    public function user2()
    {
        return $this->belongsTo('App\Models\User', 'user2_id');
    }
    public function messages()
    {
        return $this->hasMany('App\Models\Message');
    }

}
