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
        // full path
        $newFile = $request->file->getClientOriginalName();
        // full path without ext
        $newfile_info = pathinfo($newFile, PATHINFO_FILENAME);
        // extension path of the file
        $newfile_info_ext = pathinfo($newFile, PATHINFO_EXTENSION);
        // si l'url complet du fichier existe dans la db - base_path
        $existing_file_url = Media::where('base_path', '=', $newFile)->first();
        // le nombre de duplicate base_path dans la db
        $count_file = Media::where('base_path', '=', $newFile)->count();
        // poid du fichier
        $fileSize = $request->file('file')->getSize() / 1024;
        // si l'url complet existe dans la db - base_path
        if($existing_file_url) {
            $file_iteration_url = $newfile_info . "_" . $count_file + 1 . "." . $newfile_info_ext;
            // $request->file->move(public_path('files'), $file_iteration_url);
            Storage::putFileAs('public/medias',$request->file('file'), $file_iteration_url);
            Media::create([
                'url' => $file_iteration_url,
                'base_path' => $newFile,
                'description' => $request->description,
                'user_id' => Auth::user()->id,
                'file_size' => $fileSize,
                'provider' => $newfile_info_ext,
            ]);
            // si l'url complet n'existe pas dans la db - base_path
        } else {
            Media::create([
                'url' => $newFile,
                'base_path' => $newFile,
                'description' => $request->description,
                'user_id' => Auth::user()->id,
                'file_size' => $fileSize,
                'provider' => $newfile_info_ext,
            ]);
            // $request->file->move(public_path('files'), $newFile);
            Storage::putFileAs('public/medias',$request->file('file'), $newFile);
        }
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
