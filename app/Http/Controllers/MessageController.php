<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\PusherBroadcast;
use App\Models\Message;
use Auth;
use App\Models\User;
use App\Models\Chat;

class MessageController extends Controller
{
    public function index()
    {
        $userId = Auth::user()->id;

        // Fetch messages where the sender or receiver ID matches the authenticated user's ID
        $messages = Message::where(function ($query) use ($userId) {
            $query->where('sender_id', $userId)
                ->orWhere('receiver_id', $userId);
        })->get();

        $users = User::all();

        return view('chat')->with([
            'users' => $users,
            'messages' => $messages,
        ]);
    }

    public function broadcast(Request $request)
    {
        $message = new Message();
        $message->sender_id = Auth::user()->id;
        $message->receiver_id = $request->receiverid === '1' ? '1' : Auth::user()->id;
        $message->content = $request->message;
        $message->save();

        broadcast(new PusherBroadcast($request->get('message')))->toOthers();
        return view('broadcast', ['message' => $request->get('message')]);
    }

    public function receive(Request $request)
    {
        // Check if the sender is user ID 1 or the message is intended for the current user
        $senderId = $request->senderid;
        $receiverId = Auth::user()->id;

        if ($senderId === '1' || $receiverId === $senderId) {
            return view('receive', ['message' => $request->get('message')]);
        } else {
            // Handle unauthorized access or ignore the message
            // For example, return an empty response or an error message
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    }
}
