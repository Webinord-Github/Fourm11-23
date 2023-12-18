<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReplyLike;
use App\Models\ConversationLike;
use Auth;

class LikesController extends Controller
{
    function replyLike(Request $request)
    {
        $reply_id = $request->input('reply_id');
        $user_id = Auth::user()->id;
    
        // Check if the user has already liked the conversation
        $existingLike = ReplyLike::where('user_id', $user_id)
            ->where('reply_id', $reply_id)
            ->first();
    
        // If the like doesn't exist, create a new like
        if (!$existingLike) {
            ReplyLike::create([
                'user_id' => $user_id,
                'reply_id' => $reply_id,
            ]);
            // Return a success message or handle it accordingly
            return response()->json(['message' => 'Like added successfully']);
        } 
        
        // If the like exists, delete the record
        $existingLike->delete();
        return response()->json(['message' => 'Like removed successfully']);
    }
    
    public function conversationLike(Request $request)
    {
        $conversation_id = $request->input('conversation_id');
        $user_id = Auth::user()->id;
    
        // Check if the user has already liked the conversation
        $existingLike = ConversationLike::where('user_id', $user_id)
            ->where('conversation_id', $conversation_id)
            ->first();
    
        // If the like doesn't exist, create a new like
        if (!$existingLike) {
            ConversationLike::create([
                'user_id' => $user_id,
                'conversation_id' => $conversation_id,
            ]);
            // Return a success message or handle it accordingly
            return response()->json(['message' => 'Like added successfully']);
        } 
        
        // If the like exists, delete the record
        $existingLike->delete();
        return response()->json(['message' => 'Like removed successfully']);
    }
    
}
