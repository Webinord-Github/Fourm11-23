<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\PusherBroadcast;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class MessageController extends Controller
{
    public function index()
    {
        $users = User::all();
        $messages = Message::all();
        return view('chat')->with([
            'users'=> $users,
            'messages' => $messages,
        ]);
    }
    

    public function broadcast(Request $request)
    {
    
        $message = new Message();
        $message->sender_id = Auth::user()->id;
        $message->receiver_id = $request->receiver_id;
        $message->content = $request->message;
        $message->save();
        broadcast(new PusherBroadcast($request->get('message')))->toOthers();
        return view('broadcast', ['message' => $request->get('message')]);
    }

    public function receive(Request $request)
    {
        $message = new Message();
        $message->sender_id = Auth::user()->id;
        $message->receiver_id = $request->receiver_id;
        $message->content = $request->message;
        $message->save();
        return view('receive', ['message' => $request->get('message')]);
    }
    
}
