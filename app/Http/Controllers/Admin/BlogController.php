<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Media;
use App\Models\Thematique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Auth;

class BlogController extends Controller
{
    public function index()
    {
        return view('admin.blog.index', ['posts' => Post::all(), 'thematiques' => Thematique::all()]);
    }

    public function create()
    {
        return view('admin.blog.create', ['thematiques' => Thematique::all()]);
    }

    public function store(Request $request)
    {

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,webp'],
            'thematiques' => ['required', 'array', 'max:3'],
            'status' => ['required', 'string']
        ]);

        $post = new Post();

        $excerpt = $request->body;
        if(strlen($excerpt)>150) {
            substr_replace($excerpt, '...', 150);
        }

        $thematiques_selected = [];

        foreach ($request->thematiques as $thematique) {
            array_push($thematiques_selected, $thematique);
        }

        $post->user_id = Auth::user()->id;
        $post->title = $request->title;
        $post->slug = $request->title;
        $post->body = $request->body;
        $post->excerpt = $excerpt;
        $post->status = $request->status;
        $post->published_at = $request->published_at;

        $file_original_name = $request->image->getClientOriginalName();
        $file_name_only = pathinfo($file_original_name, PATHINFO_FILENAME);
        $file_provider = pathinfo($file_original_name, PATHINFO_EXTENSION);
        $file_size = $request->image->getSize() / 1024;
        $existing_file_url = Media::where('name', '=', $file_original_name)->first();
        $count_file = Media::where('original_name', '=', $file_original_name)->count();

        if($existing_file_url) {
            $file_name = $file_name_only . "_" . $count_file . "." . $file_provider;
        } else {
            $file_name = $file_original_name;
        }

        $media = new Media();
        $media->user_id = Auth::user()->id;
        $media->path = '/storage/medias/';
        $media->name = $file_name;
        $media->original_name = $file_original_name;
        $media->size = $file_size;
        $media->provider = $file_provider;
        $media->save();
        Storage::putFileAs('public/medias',$request->image, $file_name);
        
        $post->image_id = $media->id;
        $post->save();
        $post->thematiques()->sync($thematiques_selected);

        return redirect()->route('posts.index')->with('status', "$post->title a été créé.");
    }

    public function show(Post $post)
    {
        //
    }

    public function edit(Post $post)
    {
        $thematiques_selected = Post::find($post->id)->thematiques;
        return view('admin.blog.edit', ['post' => $post, 'thematiques' => Thematique::all(), 'thematiques_selected' => $thematiques_selected]);
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            // 'slug' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'image' => ['image', 'mimes:jpeg,png,jpg,webp'],
            'thematiques' => ['required', 'array', 'max:3'],
            'status' => ['required', 'string']
        ]);

        $excerpt = $request->body;
        if(strlen($excerpt)>150) {
            substr_replace($excerpt, '...', 150);
        }

        $thematiques_selected = [];

        foreach ($request->thematiques as $thematique) {
            array_push($thematiques_selected, $thematique);
        }

        $post->title = $request->title;
        $post->slug = $request->title;
        $post->body = $request->body;
        $post->excerpt = $excerpt;
        $post->status = $request->status;
        $post->published_at = $request->published_at;

        if($request->image) {
            $file_original_name = $request->image->getClientOriginalName();
            $file_name_only = pathinfo($file_original_name, PATHINFO_FILENAME);
            $file_provider = pathinfo($file_original_name, PATHINFO_EXTENSION);
            $file_size = $request->image->getSize() / 1024;
            $existing_file_url = Media::where('name', '=', $file_original_name)->first();
            $count_file = Media::where('original_name', '=', $file_original_name)->count();
    
            if($existing_file_url) {
                $file_name = $file_name_only . "_" . $count_file . "." . $file_provider;
            } else {
                $file_name = $file_original_name;
            }
    
            $media = new Media();
            $media->user_id = Auth::user()->id;
            $media->path = '/storage/medias/';
            $media->name = $file_name;
            $media->original_name = $file_original_name;
            $media->size = $file_size;
            $media->provider = $file_provider;
            $media->save();
            Storage::putFileAs('public/medias',$request->image, $file_name);
            
            $post->image_id = $media->id;
        }

        $post->save();
        $post->thematiques()->sync($thematiques_selected);

        return redirect()->route('posts.index')->with('status', "$post->title a été édité.");
    }

    public function destroy(Post $post)
    {
        $post->delete();
        $post->thematiques()->detach();

        return redirect()->route('posts.index')->with('status', "$post->title a été supprimé.");
    }
}
