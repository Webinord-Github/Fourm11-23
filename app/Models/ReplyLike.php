<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReplyLike extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'reply_id',
    ];
    
    public function users()
    {
        return $this->hasMany('App\Models\User');
    }
    public function reply()
    {
        return $this->BelongsTo('App\Models\Reply');
    }
}
