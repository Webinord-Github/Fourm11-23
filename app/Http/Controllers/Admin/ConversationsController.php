<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ConversationsRequest;
use Illuminate\Http\Request;
use App\Models\Conversation;
use App\Models\Notification;
use App\Models\Page;
use App\Models\Reply;
use Illuminate\Validation\Rule;
use Auth;

class ConversationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conversations = Conversation::paginate(25);
   
        return view('admin.conversations.index')->with([
            'conversations' => $conversations,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.conversations.create')->with([
            'model' => new Conversation(),
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ConversationsRequest $request)
    {
        $conversation = Auth::user()->conversations()->save(new Conversation($request->only([
            'title', 'body'])));

        $title = $request->title;

        $cutTitle = strlen($title) > 80 ? substr($title, 0, 80) . '...' : $title;


        $notification = new Notification();
        $notification->sujet = 'Nouvelle conversation!' . $cutTitle;
        $notification->type = 'Conversation';
        $notification->notif_link = '/forum';   
        $notification->conversation_id = $conversation->id;
        $notification->save(); 

        return redirect()->route('conversations.index')->with('status', 'Opération réussie');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $conversation = Conversation::findOrFail($id);

        $conversation->delete();

        return redirect()->route('conversations.index')->with('success', 'Conversation deleted successfully');
    }
}
