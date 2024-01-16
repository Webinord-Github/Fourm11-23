<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ConversationsRequest;
use Illuminate\Http\Request;
use App\Models\Conversation;
use App\Models\Page;
use App\Models\Reply;
use App\Models\Thematique;
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
            'thematiques' => Thematique::all()
        ]);
    }

    public function view() {
        $conversations = Conversation::with('replies')->get();
        $page = Page::where('url', '=', 'forum')->firstOrFail();
        
        return view('frontend.forum')->with([
            'conversations' => $conversations,
            'page' => $page,
            // 'thematiques' => Thematique::all()
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

        Auth::user()->conversations()->save(new Conversation($request->only([
            'title', 'body'
        ])))->thematiques()->sync($thematiques_selected);

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
        //
    }
}
