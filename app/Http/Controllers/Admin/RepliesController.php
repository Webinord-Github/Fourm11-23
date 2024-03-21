<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reply;
use App\Models\Notification;
use App\Models\User;
use App\Models\Signalement;
use App\Models\ConversationBookmarks;
use App\Models\Conversation;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\AutoEmail;
use App\Models\AutomaticEmail;

class RepliesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
        $validedData = $request->validate([
            'body' => ['required', 'string'],
            'conversation_id' => ['required', 'numeric'],
        ]);
   
        $reply = new Reply();
        $reply->conversation_id = $validedData['conversation_id'];
        $reply->body = $validedData['body'];
        $reply->user_id = Auth::user()->id;
        $reply->save();
        $formattedCreatedAt = Carbon::parse($reply->created_at)->format('Y-m-d H:i:s');

  
        $cutBody = strlen($validedData['body']) > 40 ? substr($validedData['body'], 0, 20) . '...' : $validedData['body'];
        

        $notification = new Notification();
        $notification->sujet = Auth::user()->firstname . " " . "a répondu:" . " " . $cutBody;
        $notification->notif_link = '/forum';
        $notification->type = "Reply";
        $notification->reply_id = $reply->id;
        $notification->conversation_id = $request->conversation_id;
        $notification->reply_author_id = Auth::user()->id;
        $notification->save();

        $existBookmarks = ConversationBookmarks::where('conversation_id', $request->conversation_id)
            ->where('user_id', Auth::user()->id)
            ->exists();
        if (!$existBookmarks) {
            $conversationBookmarks = new ConversationBookmarks();
            $conversationBookmarks->conversation_id = $request->conversation_id;
            $conversationBookmarks->user_id = Auth::user()->id;
            $conversationBookmarks->save();
        }


        return response()->json([
            'message' => 'Reply created successfully',
            'body' => $reply->body,
            'name' => auth()->user()->firstname,
            'created_at' => $formattedCreatedAt,
            'id' => $reply->id,
            'image' => auth()->user()->image,
        ]);
    }
    public function userReply(Request $request)
    {
        $reply = Auth::user()->replies()->save(new Reply([
            'body' => $request->body,
            'conversation_id' => $request->conversation_id,
            'parent_id' => $request->parent_id

        ]));
        $formattedCreatedAt = Carbon::parse($reply->created_at)->format('Y-m-d H:i:s');
        $title = $request->title;
        $cutTitle = strlen($title) > 40 ? substr($title, 0, 40) . '...' : $title;

        $notification = new Notification();
        $notification->sujet = Auth::user()->firstname . " " . "a répondu:" . " " . $request->body;
        $notification->notif_link = '/forum';
        $notification->type = "Reply";
        $notification->reply_id = $reply->id;
        $notification->conversation_id = $request->conversation_id;
        $notification->reply_author_id = Auth::user()->id;
        $notification->save();

        $existBookmarks = ConversationBookmarks::where('conversation_id', $request->conversation_id)
            ->where('user_id', Auth::user()->id)
            ->exists();
        if (!$existBookmarks) {
            $conversationBookmarks = new ConversationBookmarks();
            $conversationBookmarks->conversation_id = $request->conversation_id;
            $conversationBookmarks->user_id = Auth::user()->id;
            $conversationBookmarks->save();
        }


        return response()->json([
            'message' => 'Reply created successfully',
            'body' => $reply->body,
            'name' => auth()->user()->firstname,
            'created_at' => $formattedCreatedAt,
            'id' => $reply->id,
            'reply_id' => $reply->parent_id,
            'image' => auth()->user()->image
        ]);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
     * @param  \App\Models\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $replyId = $request->input('reply_id');

        // Find the reply to be deleted
        $reply = Reply::find($replyId);
        if (!$reply) {
            return response()->json(['error' => 'Reply not found'], 404);
        }

        // Check if it's a child reply or a parent comment
        if ($reply->parent_id !== null) {
            // If it's a child reply, delete only this reply
            $reply->delete();
            return response()->json(['message' => 'Child reply deleted successfully'], 200);
        } else {
            // If it's a parent comment, delete the parent and all associated child replies
            $childReplies = Reply::where('parent_id', $replyId)->get();
            foreach ($childReplies as $childReply) {
                $childReply->delete();
            }

            // Delete the parent comment
            $reply->delete();
            return response()->json(['message' => 'Parent comment and associated child replies deleted successfully'], 200);
        }
    }
    public function replyReport(Request $request)
    {
        $authorid = $request->input('authorid');
        $authorName = User::where('id', $authorid)->first();
        $conversationTitle = Conversation::where('id', $request->input('conversationid'))->first();
        $authorComments = $request->input('authorComments');
        $conversationId = $request->input('conversationid');
        $replyid = $request->input('replyid');
        $signalement = new Signalement;
        $signalement->reported_author_user_id = $authorid;
        $signalement->reported_user_user_id = Auth::user()->id;
        $signalement->report = $authorComments;
        $signalement->conversation_id = $conversationId;
        $signalement->reply_id = $replyid;
        $signalement->fixed = false;
        $signalement->save();

        $to_email = Auth::user()->email;
        $automaticEmail = AutomaticEmail::where('id', 4)->first();
        $userFirstName = Auth::user()->firstname;
        $emailBody = "<h1 style='text-align:center;'>Réception du signalement</h1><p>Bojour <strong>$userFirstName</strong>,</p>" . $automaticEmail->content;
        $customSubject = 'Courriel de la fourmilière';
        Mail::to($to_email)->send(new AutoEmail($emailBody, $customSubject));

        $to_emailAdmin = "info@webinord.ca";
        $emailBodyAdmin = "<h1 style='text-align:center;'>Nouveau signalement</h1>
        <p><strong>Utilisateur qui a signalé: </strong>" . Auth::user()->email . "</p>
        <p><strong>Commentaire: </strong>" . $authorComments .  "</p>
        <p><strong>Auteur du commentaire: </strong>" . $authorName->firstname . " " . $authorName->lastname . "</p>
        <p><strong>Titre de la conversation: </strong>" . $conversationTitle->title . "</p>"
        ;
        $customSubjectAdmin = 'Courriel de la fourmilière';
        Mail::to($to_emailAdmin)->send(new AutoEmail($emailBodyAdmin, $customSubjectAdmin));


        return response()->json([
            'message' => 'Report sent successfully',
        ]);
    }
}
