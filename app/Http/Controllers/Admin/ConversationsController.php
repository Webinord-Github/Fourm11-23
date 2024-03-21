<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ConversationsRequest;
use Illuminate\Http\Request;
use App\Models\Conversation;
use App\Models\Notification;
use App\Models\Page;
use App\Models\Reply;
use App\Models\Thematique;
use Illuminate\Support\Facades\Mail;
use App\Mail\AutoEmail;
use App\Models\AutomaticEmail;
use App\Models\ConversationBookmarks;
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
        $conversations = Conversation::paginate(10);

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
            'thematiques' => Thematique::all()
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
        $request->validate([
            'thematiques' => ['required', 'array', 'max:3']
        ]);

        $thematiques_selected = [];

        foreach ($request->thematiques as $thematique) {
            array_push($thematiques_selected, $thematique);
        }

        $conversation = Auth::user()->conversations()->save(new Conversation($request->only([
            'title', 'body'
        ])));
        $conversation->published = true;
        $conversation->notified = true;
        $conversation->save();

        $conversation->thematiques()->sync($thematiques_selected);

        $title = $request->title;

        $cutTitle = strlen($title) > 80 ? substr($title, 0, 80) . '...' : $title;


        $notification = new Notification();
        $notification->sujet = 'Une nouvelle conversation a été ajoutée:<br>' . $cutTitle;
        $notification->type = 'BasicNotif';
        $notification->notif_link = "/forum#c$conversation->id";
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
    public function show($id)
    {
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

    public function conversation_added_by_user(Request $request)
    {
        $request->validate([
            'thematiques' => ['required', 'array', 'max:3'],
            'title' => ['required', 'max:255', 'string'],
            'body' => ['required', 'max:2000', 'string'],
        ], [
            'thematiques.required' =>'Choisir au moins une thématique',
            'thematiques.array' => 'Choisir maximum trois thématiques',
            'title.required' => 'Le titre est requis',
            'body.required' => 'Le contenu est requis',
        ]);

        $thematiques_selected = [];

        foreach ($request->thematiques as $thematique) {
            array_push($thematiques_selected, $thematique);
        }

        $conversation = Auth::user()->conversations()->save(new Conversation($request->only([
            'title', 'body'
        ])));
        $conversation->published = false;
        $conversation->notified = false;
        $conversation->save();

        $conversation->thematiques()->sync($thematiques_selected);

        $to_email = 'info@webinord.ca';
        $emailBody = "
        <h1 style='text-align:center;'>
        Nouvelle discussion ajoutée par un.e utilisateur.trice</h1>
        <p><strong>Titre:</strong> " . $request->title . "</p>
        <p><strong>Contenu:</strong> " . $request->body . "</p>
        <p><strong>Nom de l'utilisateur:</strong> " . Auth::user()->firstname . " " . Auth::user()->lastname . "</p>
        <p><strong>Courriel de l'utilisateur:</strong> " . Auth::user()->email . "</p>
        ";
        $customSubject = 'Courriel de La Fourmilière';
        Mail::to($to_email)->send(new AutoEmail($emailBody, $customSubject));

        return back()->with('status', 'Conversation Soumise. Un/une administrateur.trice revisera votre demande. Merci!');
    }

    public function conversationsPublished(Request $request)
    {
        foreach ($request->input('conversation_ids') as $conversationId) {
            $conversation = Conversation::find($conversationId);
            $isChecked = $request->has('checkbox_' . $conversationId);

            // Update the 'published' attribute based on checkbox status

            $conversation->published = $isChecked;

            if ($conversation->notified == false) {
                $conversation->notified = true;
                $notification = new Notification();
                $notification->sujet = 'Nouvelle discussion ajoutée:<br> ' . '<span style="font-size:12px">' . $conversation->title . '</span>';
                $notification->notif_link = '/';
                $notification->type = "BasicNotif";
                $notification->save();

       
            }
            $conversation->save();
        }

        return back()->with('success', 'Les discussions ont été mises à jour!');
    }

    public function conversationBookmark(Request $request)
    {
        $validatedData = $request->validate([
            'convid' => ['numeric'],
        ]);
        $userid = Auth::user()->id;

        $existingBookmarked = ConversationBookmarks::where('conversation_id', $validatedData['convid'])
        ->where('user_id', $userid)
        ->first();
        
        if(!$existingBookmarked) {
            $newBookmark = new ConversationBookmarks();
            $newBookmark->user_id = $userid;
            $newBookmark->conversation_id = $validatedData['convid'];
            $newBookmark->save();
        } else {
            $existingBookmarked->delete();
        }
        return response()->json([
            'message' => $userid,
        ]);
    }
}