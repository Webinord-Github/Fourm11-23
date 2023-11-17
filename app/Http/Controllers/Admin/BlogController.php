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
            'slug' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,webp'],
            'thematiques' => ['required', 'array'],
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
        $post->slug = $request->slug;
        $post->body = $request->body;
        $post->excerpt = $excerpt;
        $post->status = $request->status;
        $post->published_at = $request->published_at;

        $newFile = $request->image->getClientOriginalName();
        $newfile_info = pathinfo($newFile, PATHINFO_FILENAME);
        $newfile_info_ext = pathinfo($newFile, PATHINFO_EXTENSION);
        $existing_file_url = Media::where('base_path', '=', $newFile)->first();
        $count_file = Media::where('base_path', '=', $newFile)->count();
        $fileSize = $request->file('image')->getSize() / 1024;

        if($existing_file_url) {
            $file_iteration_url = $newfile_info . "_" . $count_file + 1 . "." . $newfile_info_ext;
            Storage::putFileAs('public/medias',$request->image, $file_iteration_url);
            Media::create([
                'url' => $file_iteration_url,
                'base_path' => $newFile,
                'description' => $request->description,
                'user_id' => Auth::user()->id,
                'file_size' => $fileSize,
                'provider' => $newfile_info_ext,
            ]);
            $post->image = $file_iteration_url;
        } else {
            Media::create([
                'url' => $newFile,
                'base_path' => $newFile,
                'description' => $request->description,
                'user_id' => Auth::user()->id,
                'file_size' => $fileSize,
                'provider' => $newfile_info_ext,
            ]);
            Storage::putFileAs('public/medias',$request->image, $newFile);
            $post->image = $newFile;
        }

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
            'slug' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'image' => ['image', 'mimes:jpeg,png,jpg,webp'],
            'thematiques' => ['required', 'array'],
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
        $post->slug = $request->slug;
        $post->body = $request->body;
        $post->excerpt = $excerpt;
        $post->status = $request->status;
        $post->published_at = $request->published_at;

        if($request->image != null) {
            $newFile = $request->image->getClientOriginalName();
            $newfile_info = pathinfo($newFile, PATHINFO_FILENAME);
            $newfile_info_ext = pathinfo($newFile, PATHINFO_EXTENSION);
            $existing_file_url = Media::where('base_path', '=', $newFile)->first();
            $count_file = Media::where('base_path', '=', $newFile)->count();
            $fileSize = $request->file('image')->getSize() / 1024;
    
            if($existing_file_url) {
                $file_iteration_url = $newfile_info . "_" . $count_file + 1 . "." . $newfile_info_ext;
                Storage::putFileAs('public/medias',$request->image, $file_iteration_url);
                Media::create([
                    'url' => $file_iteration_url,
                    'base_path' => $newFile,
                    'description' => $request->description,
                    'user_id' => Auth::user()->id,
                    'file_size' => $fileSize,
                    'provider' => $newfile_info_ext,
                ]);
                $post->image = $file_iteration_url;
            } else {
                Media::create([
                    'url' => $newFile,
                    'base_path' => $newFile,
                    'description' => $request->description,
                    'user_id' => Auth::user()->id,
                    'file_size' => $fileSize,
                    'provider' => $newfile_info_ext,
                ]);
                Storage::putFileAs('public/medias',$request->image, $newFile);
                $post->image = $newFile;
            }
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
