<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Media;
use Auth;
use Illuminate\Support\Facades\Storage;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.events.index', ['events' => Event::all()]);
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'desc' => ['required', 'string'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,webp'],
            'nb_places' => ['required', 'integer'],
            'start_at' => ['required'],
            'end_at' => ['required'],
        ]);

        $event = new Event();

        $event->title = $request->title;
        $event->desc = $request->desc;
        $event->nb_places = $request->nb_places;
        $event->start_at = $request->start_at;
        $event->end_at = $request->end_at;

        $newFile = $request->image->getClientOriginalName();
        $newfile_info = pathinfo($newFile, PATHINFO_FILENAME);
        $newfile_info_ext = pathinfo($newFile, PATHINFO_EXTENSION);
        $existing_file_url = Media::where('base_path', '=', $newFile)->first();
        $count_file = Media::where('base_path', '=', $newFile)->count();
        $fileSize = $request->file('image')->getSize() / 1024;

        if($existing_file_url) {
            $file_iteration_url = $newfile_info . "_" . $count_file + 1 . "." . $newfile_info_ext;
            Storage::putFileAs('public/medias',$request->image, $file_iteration_url);
            // Storage::move('public/medias' . $request->image, 'public/medias' . $file_iteration_url);
            Media::create([
                'url' => $file_iteration_url,
                'base_path' => $newFile,
                'description' => $request->description,
                'user_id' => Auth::user()->id,
                'file_size' => $fileSize,
                'provider' => $newfile_info_ext,
            ]);
            $event->image = $file_iteration_url;
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
            $event->image = $newFile;
        }

        $event->save();

        return redirect('/admin/events')->with('status', "$event->title was created.");
    }

    public function update($id)
    {
        $event = Event::findOrFail($id);
        return view('admin.events.index', ['events' => $event]);
    }

    public function storeUpdate(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'desc' => ['required', 'string'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,webp'],
            'nb_places' => ['required', 'integer'],
            'start_at' => ['required'],
            'end_at' => ['required'],
        ]);

        $event = Event::find($request->id);

        $event->title = $request->title;
        $event->desc = $request->desc;
        $event->nb_places = $request->nb_places;
        $event->start_at = $request->start_at;
        $event->end_at = $request->end_at;

        $newFile = $request->image->getClientOriginalName();
        $newfile_info = pathinfo($newFile, PATHINFO_FILENAME);
        $newfile_info_ext = pathinfo($newFile, PATHINFO_EXTENSION);
        $existing_file_url = Media::where('base_path', '=', $newFile)->first();
        $count_file = Media::where('base_path', '=', $newFile)->count();
        $fileSize = $request->file('image')->getSize() / 1024;

        if($existing_file_url) {
            $file_iteration_url = $newfile_info . "_" . $count_file + 1 . "." . $newfile_info_ext;
            Storage::putFileAs('public/medias',$request->image, $file_iteration_url);
            // Storage::move('public/medias' . $request->image, 'public/medias' . $file_iteration_url);
            Media::create([
                'url' => $file_iteration_url,
                'base_path' => $newFile,
                'description' => $request->description,
                'user_id' => Auth::user()->id,
                'file_size' => $fileSize,
                'provider' => $newfile_info_ext,
            ]);
            $event->image = $file_iteration_url;
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
            $event->image = $newFile;
        }

        $event->save();

        return redirect('/admin/events')->with('status', "$event->title was edited.");
    }

    public function destroy($id)
    {
        $event = Event::find($id);
        Event::destroy($id);

        return redirect('/admin/events')->with('status', "$event->title was deleted.");
    }
}
