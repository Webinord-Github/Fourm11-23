<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Media;
use App\Models\Thematique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.test.index', ['thematiques' => Thematique::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $infos = $_POST;

        $post = new Post();

        // $excerpt = $request->body;
        // if(strlen($excerpt)>150) {
        //     substr_replace($excerpt, '...', 150);
        // }
        dd($infos['content']);
        dd($infos['image']);

        $post->user_id = Auth::user()->id;
        $post->title = $infos['title'];
        $post->slug = $infos['slug'];
        $post->body = $infos['content'];
        $post->excerpt = 'Test';
        $post->status = $infos['status'];
        $post->publish_at = $infos['publish_at'];

        // $newFile = $request->image->getClientOriginalName();
        // $newfile_info = pathinfo($newFile, PATHINFO_FILENAME);
        // $newfile_info_ext = pathinfo($newFile, PATHINFO_EXTENSION);
        // $existing_file_url = Media::where('base_path', '=', $newFile)->first();
        // $count_file = Media::where('base_path', '=', $newFile)->count();
        // $fileSize = $request->file('image')->getSize() / 1024;

        // if($existing_file_url) {
        //     $file_iteration_url = $newfile_info . "_" . $count_file + 1 . "." . $newfile_info_ext;
        //     Storage::putFileAs('public/medias',$request->image, $file_iteration_url);
        //     Media::create([
        //         'url' => $file_iteration_url,
        //         'base_path' => $newFile,
        //         'description' => $request->description,
        //         'user_id' => Auth::user()->id,
        //         'file_size' => $fileSize,
        //         'provider' => $newfile_info_ext,
        //     ]);
        //     $post->image = $file_iteration_url;
        // } else {
        //     Media::create([
        //         'url' => $newFile,
        //         'base_path' => $newFile,
        //         'description' => $request->description,
        //         'user_id' => Auth::user()->id,
        //         'file_size' => $fileSize,
        //         'provider' => $newfile_info_ext,
        //     ]);
        //     Storage::putFileAs('public/medias',$request->image, $newFile);
        //     $post->image = $newFile;
        // }

        $post->save();
        return redirect()->route('posts.index')->with('status', "$post->title a été créé.");

        // $thematiques_selected = [];

        // foreach ($request->thematiques as $thematique) {
        //     array_push($thematiques_selected, $thematique);
        // }

        // $post->thematiques()->sync($thematiques_selected);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
