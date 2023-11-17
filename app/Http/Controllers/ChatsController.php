<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Chat;
use App\Models\Message;
use App\Models\User;

class ChatsController extends Controller
{ 
  
    public function index() 
    {
        $userId = auth()->id();
    
        $chats = Chat::where(function ($query) use ($userId) {
                    $query->where('user1_id', $userId)
                        ->orWhere('user2_id', $userId);
                })->get();
    
        $messages = Message::all();
        $users = User::all();
    
        return view('chat')->with([
            'users' => $users,
            'messages' => $messages,
            'chats' => $chats,
        ]);
    }
    

    public function show(Chat $chat)
    {
        $user = Auth::user();
        if ($user->id == $conversation->user1_id || $user->id == $conversation->user2_id) {
            // Logic to display the conversation
        } else {
            abort(403, 'Unauthorized action.');
        }
    }
    public function store(Request $request)
    {
        $user1 = Auth::user()->id;
        $user2 = $request->receiverId;
    
        // Check if a conversation exists between the two users
        $conversationExists = Chat::where(function ($query) use ($user1, $user2) {
            $query->where('user1_id', $user1)
                ->where('user2_id', $user2);
        })->orWhere(function ($query) use ($user1, $user2) {
            $query->where('user1_id', $user2)
                ->where('user2_id', $user1);
        })->exists();
    
        // If the conversation does not exist, handle the situation accordingly
        if (!$conversationExists) {
            $randomChatId = mt_rand(100, 999999999999999999); // Generate a random number between 3 and 18 digits
    
            // Check if the random chat id already exists in the database
            $existingChat = Chat::where('chat_id', $randomChatId)->exists();
            while ($existingChat) {
                // If the generated random chat id already exists, generate a new one until it is unique
                $randomChatId = mt_rand(100, 999999999999999999);
                $existingChat = Chat::where('chat_id', $randomChatId)->exists();
            }
    
            // Create a new conversation entry in the Chat model with the generated random chat id
            Chat::create([
                'chat_id' => $randomChatId,
                'user1_id' => $user1,
                'user2_id' => $user2,
            ]);
        }
    
        // Return a JSON response with the relevant data
        return response()->json([
            'user1' => $user1,
            'user2' => $user2,
            'conversationExists' => $conversationExists,
        ]);
    }

    public function view($chatId) {
        $chat = Chat::where('chat_id', $chatId)
                    ->where(function ($query) {
                        $userId = auth()->id();
                        $query->where('user1_id', $userId)
                              ->orWhere('user2_id', $userId);
                    })
                    ->firstOrFail();
    
        $messages = Message::where('chat_id', $chat->chat_id)->get(); // Assuming 'Message' is the model for messages
    
        return view('frontend.SingleChatComponent')->with([
            'chat' => $chat,
            'messages' => $messages,
        ]);
    }
    
    
    
    
    
    
    
    
}
