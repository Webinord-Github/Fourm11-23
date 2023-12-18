<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use App\Http\Requests\NewMediaRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
// use File;
use Auth;

class MediasController extends Controller
{

    public function __construct() {
        $this->middleware('admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $files = File::allFiles(public_path('media'));
        // return view('admin.media.index', ['url' => $files]);

        $files = Media::paginate(20);
        

        return view('admin.medias.index', ['model' => $files]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.medias.create')->with([
            'model' => new Media(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NewMediaRequest $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:jpeg,png,jpg,webp']
        ]);

        $file_original_name = $request->file('image')->getClientOriginalName();
        $file_name_only = pathinfo($file_original_name, PATHINFO_FILENAME);
        $file_provider = pathinfo($file_original_name, PATHINFO_EXTENSION);
        $file_size = $request->file('image')->getSize() / 1024;
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
        Storage::putFileAs('public/medias',$request->file('image'), $file_name);

        return redirect()->route('medias.index');                
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function show(Media $media)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function edit(Media $media)
    {

        $user_name = User::where('id', $media->user_id)->first();
        return view('admin.medias.edit')->with([
            'model' => $media,
            'user' => $user_name,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Media $media)
    {
            $media->fill($request->only([
                'description'
            ]));

            $media->save();
        
            return redirect()->route('medias.index')->with('status', 'image updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function destroy(Media $media)
    {
        if(Storage::exists('public/medias/' . $media->url)) {
            // File::delete(public_path('files/' . $media->url));
            Storage::delete('public/medias/' . $media->url);
            $media->delete();
            return redirect()->route('medias.index')->with('status', "$media->url has been deleted.");
        } else {
            return redirect()->route('medias.index')->with('status', "File doesn't exists");
        }
    }
}
