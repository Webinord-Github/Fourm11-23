<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatbotMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'chat_id',
        'body',
        'sender',
        'receiver',
        'received'
    ];

    public function chat()
    {
        return $this->belongsTo(Chatbot::class);
    }
    public function chatbot()
    {
        return $this->belongsTo(Chatbot::class, 'chat_id');
    }
}
