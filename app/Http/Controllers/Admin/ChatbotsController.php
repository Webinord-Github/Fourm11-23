<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chatbot;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ChatbotMessage;
use App\Models\ChatbotActive;
use Auth;

class ChatbotsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Fetch users along with their most recent chatbot message
        $users = User::with(['chatbotMessages' => function ($query) {
            $query->latest()->limit(1);
        }])->get();
    
        // Sort users based on the timestamp of their most recent chatbot message
        $users = $users->sortByDesc(function ($user) {
            return optional($user->chatbotMessages->first())->created_at;
        });
    
        return view('admin.chatbot.index')->with([
            'users' => $users,
        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => ['required', 'numeric'],
            'message' => ['required'],
        ]);

        $adminId = 1;
        $conversation = Chatbot::where('admin_id', $adminId)
            ->where('user_id', $validatedData['user_id'])
            ->first();

        if (!$conversation) {
            $conversation = new Chatbot();
            $conversation->admin_id = $adminId;
            $conversation->user_id = $validatedData['user_id'];
            $conversation->save();
        }
        $newMessage = new ChatbotMessage();
        $newMessage->chat_id = $conversation->id;
        $newMessage->body = $validatedData['message'];
        $newMessage->sender = $adminId;
        $newMessage->receiver = $conversation->user_id;
        $newMessage->received = false;
        $newMessage->save();


        return response()->json(['message' => 'success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Chatbot  $chatbot
     * @return \Illuminate\Http\Response
     */
    public function show(Chatbot $chatbot)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Chatbot  $chatbot
     * @return \Illuminate\Http\Response
     */
    public function edit(Chatbot $chatbot)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Chatbot  $chatbot
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Chatbot $chatbot)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Chatbot  $chatbot
     * @return \Illuminate\Http\Response
     */
    public function destroy(Chatbot $chatbot)
    {
        //
    }

    public function userStore(Request $request)
    {
        $validatedData = $request->validate([
            'message' => ['required', 'string'],
        ]);

        $userId = Auth::user()->id;

        $adminId = 1;
        $conversation = Chatbot::where('admin_id', $adminId)
            ->where('user_id', $userId)
            ->first();

        if (!$conversation) {
            $conversation = new Chatbot();
            $conversation->admin_id = $adminId;
            $conversation->user_id = $userId;
            $conversation->save();
        }
        $newMessage = new ChatbotMessage();
        $newMessage->chat_id = $conversation->id;
        $newMessage->body = $validatedData['message'];
        $newMessage->sender = $userId;
        $newMessage->receiver = 1;
        $newMessage->received = false;
        $newMessage->save();


        return response()->json(['message' => 'success']);
    }

    // User Load messqages for admin 
    public function loadMessagesFromAdmin(Request $request) 
    {
        $adminId = 1;
        $userId = Auth::user()->id;
      
        // Fetch messages for the selected user
        $messages = ChatbotMessage::whereHas('chatbot', function ($query) use ($adminId, $userId) {
            $query->where('admin_id', $adminId)
                ->where('user_id', $userId);
        })
            ->orderBy('created_at', 'asc')
            ->get();
        
        $conversation = Chatbot::where('admin_id', $adminId)->where('user_id', $userId)->first();
        if (!$conversation) {
            $conversation = new Chatbot();
            $conversation->admin_id = $adminId;
            $conversation->user_id = $userId;
            $conversation->admin_verified = null;
            $conversation->save();
        } 
        return response()->json([
            'messages' => $messages,
        ]);

    }

    // user receives messages from admin 
    public function getInstantMessagesFromAdmin()
    {
        $user_id = Auth::user()->id;
        $conversation = Chatbot::where('admin_id', 1)->where('user_id', $user_id)->first();
        if (!$conversation) {
            $conversation = new Chatbot();
            $conversation->admin_id = 1;
            $conversation->user_id = $user_id;
            $conversation->admin_verified = now();
            $conversation->save();
        }
        $newMessages = ChatbotMessage::where('chat_id', $conversation->id)
            ->where('sender', 1)
            ->where('receiver', $user_id)
            ->get();

        foreach($newMessages as $newMessage) {
            $newMessage->received = true;
            $newMessage->save();
        }

        return response()->json(['messages' => $newMessages]);
    }

    public function getMessagesForUser(Request $request)
    {
        $adminId = 1; // Assuming this is the admin's ID
        $userId = $request->input('user_id');

        // Fetch messages for the selected user
        $messages = ChatbotMessage::whereHas('chatbot', function ($query) use ($adminId, $userId) {
            $query->where('admin_id', $adminId)
                ->where('user_id', $userId);
        })
            ->orderBy('created_at', 'asc')
            ->get();
        
        $conversation = Chatbot::where('admin_id', $adminId)->where('user_id', $userId)->first();
        if (!$conversation) {
            $conversation = new Chatbot();
            $conversation->admin_id = $adminId;
            $conversation->user_id = $userId;
            $conversation->admin_verified = now();
            $conversation->save();
        } else {
            $conversation->admin_verified = now();
            $conversation->save();
        }

        return response()->json([
            'messages' => $messages,

        ]);
    }

    public function getNewMessages(Request $request)
    {
        $user_id = $request->user_id;
        $conversation = Chatbot::where('admin_id', 1)->where('user_id', $user_id)->first();
        if (!$conversation) {
            $conversation = new Chatbot();
            $conversation->admin_id = 1;
            $conversation->user_id = $user_id;
            $conversation->admin_verified = now();
            $conversation->save();
        }
        $newMessages = ChatbotMessage::where('chat_id', $conversation->id)
            ->where('sender', $user_id)
            ->where('receiver', 1)
            ->get();

        foreach($newMessages as $newMessage) {
            $newMessage->received = true;
            $newMessage->save();
        }

        return response()->json(['messages' => $newMessages]);
    }
    
    public function getNewMessageNotif(Request $request)
    {
        $newMessagesNotif = ChatbotMessage::where('sender', '!=', 1)->where('receiver', 1)->where('received', false)->get();
        return response()->json(['message' => $newMessagesNotif]);
    }

    public function getNewMessageNotifFromAdmin(Request $request)
    {
        $newMessagesNotif = ChatbotMessage::where('sender', 1)->where('receiver', Auth::user()->id)->where('received', false)->get();
        return response()->json(['message' => $newMessagesNotif]);
    }

    public function enableChatbot(Request $request)
    {
        $isActive = $request->has('chatbotactive');
        $chatbotActive = ChatbotActive::where('id', 1)->first();
        $chatbotActive->active = $isActive;
        $chatbotActive->save();
        return back()->with('status', 'Le chatbot a été activé/désactivé avec succès');
    }
}
