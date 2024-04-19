<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class BlogGuardController extends Controller
{
    public function index()
    {
        $posts = Post::all();

        return view('admin.blogguard.index', ['posts' => $posts]);
    }


    public function store(Request $request)
    {
        foreach($request->input('post_ids') as $post_id) {
            $post = Post::find($post_id);
            if ($request->has('checkbox_'.$post_id)) {
                $post->verified = true;
            } else {
                $post->verified = false;
            }
            $post->save();
        }
    
        return redirect()->route('blogguard.index')->with('success', 'Les articles ont été mis à jour.');
    }
}
