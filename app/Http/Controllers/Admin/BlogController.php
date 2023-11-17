<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Media;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Auth;

class BlogController extends Controller
{
    public function posts()
    {
        return view('admin.blog.index', ['posts' => Post::all(), 'categories' => Category::all()]);
    }

    public function create()
    {
        return view('admin.blog.create', ['categories' => Category::all()]);
    }

    public function store(Request $request)
    {

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,webp'],
            'categories' => ['required', 'array'],
            'status' => ['required', 'string']
        ]);

        $post = new Post();

        $excerpt = $request->body;
        if(strlen($excerpt)>150) {
            substr_replace($excerpt, '...', 150);
        }

        $categories_selected = [];

        foreach ($request->categories as $category) {
            array_push($categories_selected, $category);
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
        $post->categories()->sync($categories_selected);

        return redirect('/admin/posts')->with('status', "$post->title was created.");
    }

    public function update($id)
    {
        $post = Post::findOrFail($id);
        $categories_selected = Post::find($id)->categories;
        return view('admin.blog.edit', ['post' => $post, 'categories' => Category::all(), 'categories_selected' => $categories_selected]);
    }

    public function storeUpdate(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'image' => ['image', 'mimes:jpeg,png,jpg,webp'],
            'categories' => ['required', 'array'],
            'status' => ['required', 'string']
        ]);

        $post = Post::findOrFail($request->id);

        $excerpt = $request->body;
        if(strlen($excerpt)>150) {
            substr_replace($excerpt, '...', 150);
        }

        $categories_selected = [];

        foreach ($request->categories as $category) {
            array_push($categories_selected, $category);
        }

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
        $post->categories()->sync($categories_selected);

        return redirect('/admin/posts')->with('status', "$post->title was edited.");
    }

    public function destroy($id)
    {
        $post = Post::find($id);
        Post::destroy($id);
        $post->categories()->detach();

        return redirect('/admin/posts')->with('status', "$post->title was deleted.");
    }
}
