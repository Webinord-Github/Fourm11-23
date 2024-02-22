<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'user_id',
        'published',
    ];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function replies() {
        return $this->hasMany('App\Models\Reply');
    }

    public function likes()
    {
        return $this->hasMany('App\Models\ConversationLike');
    }
    
    public function thematiques() {
        return $this->belongsToMany(Thematique::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'conversation_id');
    }
}
