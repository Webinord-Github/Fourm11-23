<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConversationLike extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'conversation_id',
    ];

    public function users()
    {
        return $this->hasMany('App\Models\User');
    }

    public function conversation()
    {
        return $this->BelongsTo('App\Models\Conversation');
    }
}
