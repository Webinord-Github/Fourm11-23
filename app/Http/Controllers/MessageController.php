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
        $users = User::all();
        $messages = Message::all();
        return view('chat')->with([
            'users' => $users,
            'messages' => $messages,
        ]);
    }

    public function show($userId)
    {
        // Retrieve the user and messages related to the current user and the user with the specified $userId
        $currentUser = Auth::user();
        $otherUser = User::find($userId);
        $users = User::all();
        $authUserId = Auth::user()->id; // Get the ID of the authenticated user
        $messages = Message::where(function ($query) use ($userId, $authUserId) {
            $query->where('sender_id', $authUserId)
                ->where('receiver_id', $userId);
        })->orWhere(function ($query) use ($userId, $authUserId) {
            $query->where('sender_id', $userId)
                ->where('receiver_id', $authUserId);
        })->get();
        // Retrieve messages between the current user and the specified user

        // Pass the necessary data to the view
        return view('frontend.SingleChatComponent', compact('currentUser', 'otherUser', 'users', 'messages'));
    }




    public function broadcast(Request $request)
    {

        $message = new Message();
        $message->sender_id = Auth::user()->id;
        $message->receiver_id = $request->receiverid;
        $message->content = $request->message;
        $message->save();

        broadcast(new PusherBroadcast($request->get('message')))->toOthers();
        return view('broadcast', ['message' => $request->get('message')]);
    }


    public function receive(Request $request)
    {

        return view('receive', ['message' => $request->get('message')]);
    }
}
