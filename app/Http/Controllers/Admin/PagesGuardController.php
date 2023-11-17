<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;

class PagesGuardController extends Controller
{
    public function index()
    {
        $pages = Page::paginate();

        return view('admin.pagesguard.index', ['pages' => $pages]);
    }


    public function store(Request $request)
    {
        foreach($request->input('page_ids') as $pageId) {
            $page = Page::find($pageId);
            if ($request->has('checkbox_'.$pageId)) {
                $page->categorie = 1;
            } else {
                $page->categorie = 2;
            }
            $page->save();
        }
    
        // Add any additional logic you may need
    
        return redirect()->route('pagesguard.index')->with('success', 'Les pages ont été mises à jour.');
    }
    
    
    
}
