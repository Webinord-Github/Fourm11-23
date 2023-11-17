<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Notification;
use App\Http\Requests\PagesRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App\Models\Menu;
use Auth;

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
        $page = Page::where('url', $url)->firstOrFail();
        return view('frontend.page')->with([
            'page' => $page,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PagesRequest $request)
    {
        $request->validate([
            'url' => 'required|unique:pages,url',
        ]);

        // Clean the 'url' input using Str::slug
        $cleanUrl = Str::slug($request->input('url'));

        Auth::user()->pages()->save(new Page($request->only([
            'title', 'content',
        ]) + ['url' => $cleanUrl]));

        $notification = new Notification();
        $notification->sujet = 'Nouvelle page créée: ' . $request->input('title');
        $notification->notif_link = '/' . $cleanUrl;
        $notification->save();

        return redirect()->route('pages.index')->with('status', 'Opération réussie');
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
        $request->validate([
            'url' => [
                'required',
                Rule::unique('pages')->ignore($page),
            ],
        ]);
        $cleanUrl = Str::slug($request->input('url'));

        $page->url = $cleanUrl;

        $page->fill($request->only([
            'title', $cleanUrl, 'content', 'categorie'
        ]));

        $page->save();

        return redirect()->route('pages.index')->with('status', 'The page was updated');
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
    

}
