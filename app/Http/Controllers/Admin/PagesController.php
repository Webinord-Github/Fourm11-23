<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Notification;
use App\Models\User;
use App\Models\Post;
use App\Models\Tool;
use App\Models\Conversation;
use App\Models\Reply;
use App\Models\ConversationBookmarks;
use App\Http\Requests\PagesRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App\Models\Event;
use App\Models\Menu;
use App\Models\Thematique;
use App\Models\Fact;
use Auth;
use Carbon\Carbon;

class PagesController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = Page::paginate(25);

        return view('admin.pages.index', ['pages' => $pages]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.create')->with([
            'model' => new Page(),
        ]);
    }

    public function view($url)
    {
        $page = Page::where('url', '/' . $url)->firstOrFail();
        $users = User::all();
        $events = Event::orderBy('start_at')->get();
        $conversations = Conversation::with('replies')->get();
        $tools = Tool::where('verified', '1')->get();
        $thematiques = Thematique::all();
        $facts = Fact::all();
        $posts = Post::where('verified', '1')->get();
        $recentConversations = Conversation::
        where('published', true)->
        orderBy('created_at', 'desc')
        ->take(5)
        ->get();
 
        // si l'utilisateur n'est pas vérifié 
        if(Auth::check()){
            if($page->id == 5 && !Auth::user()->verified) {
                return redirect('/');
            }
        }
        // page forum si pas connecté

        if($page->id == 5 && !Auth::check()) {
            return redirect('/');
        }
        if(Auth::check()) {
            $conversationBookmarks = ConversationBookmarks::where('user_id', Auth::user()->id)->get();
            $userReplies = Reply::where('user_id', Auth::user()->id)->get();
            return view('frontend.page')->with([
                'page' => $page,
                'conversations' => $conversations,
                'users' => $users,
                'events' => $events,
                'thematiques' => $thematiques,
                'tools' => $tools,
                'posts' => $posts,
                'facts' => $facts,
                'recentConversations' => $recentConversations,
                'conversationBookmarks' => $conversationBookmarks,
                'userReplies' => $userReplies,
            ]);
        } else {
            return view('frontend.page')->with([
                'page' => $page,
                'conversations' => $conversations,
                'users' => $users,
                'events' => $events,
                'thematiques' => $thematiques,
                'tools' => $tools,
                'posts' => $posts,
                'facts' => $facts,
                'recentConversations' => $recentConversations,
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PagesRequest $request)
    {

        // Clean the 'url' input using Str::slug
        $cleanUrl = Str::slug($request->input('url'));

        // Auth::user()->pages()->save(new Page($request->only([
        //     'title', 'content','meta_title','meta_desc'
        // ]) + ['url' => $cleanUrl]));

        $page = new Page();

        $page->user_id = Auth::user()->id;
        $page->title = $request->title;
        $page->url = $cleanUrl;
        $page->meta_title = $request->meta_title;
        $page->meta_desc = $request->meta_desc;
        $page->save();

        return redirect()->route('pages.index')->with('status', "La page $page->title a été créée.");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        return view('admin.pages.edit', [
            'model' => $page
            // 'orderPages' => Page::defaultOrder()->withDepth()->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(PagesRequest $request, Page $page)
    {

        $cleanUrl = Str::slug($request->input('url'));

        $page->title = $request->title;
        $page->url = $cleanUrl;
        $page->meta_title = $request->meta_title;
        $page->meta_desc = $request->meta_desc;
        $page->save();

        $page->save();

        return redirect()->route('pages.index')->with('status', "La page $page->title a été modifiée.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        $page->delete();
        return redirect()->route('pages.index')->with('status', "$page->title was deleted.");
    }

    public function updateMenuOrder(Request $request)
    {
        $orderData = json_decode($request->input('order'), true);


        foreach ($orderData as $index => $orderItem) {
            $pageId = $orderItem['pageId'];
            $parentId = $orderItem['parentId'];

            // Assuming 'Page' is the model for your pages table
            Page::where('id', $pageId)->update([
                'order' => $index + 1,
                'parent_id' => $parentId
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function homepage()
    {
        $homepage = Page::where('title', 'Accueil')->firstOrFail();
        $users = User::all();
        $posts = Post::take(3)->get();
        $tools = Tool::take(2)->get();
        $homepageEvents = Event::take(2)->get();
        $homepageForums = Conversation::take(2)->get();
        return view('frontend.page')->with([
            'page' => $homepage,
            'users' => $users,
            'homepageForums' => $homepageForums,
            'posts' => $posts,
            'tools' => $tools,
            'events' => $homepageEvents,
        ]);
    }
}
