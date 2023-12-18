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
        $events = Event::all();
        return view('admin.events.index')->with([
            'events' => $events,
        ]);
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
            'address' => ['required', 'string'],
            'link' => ['required', 'string', 'url'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,webp'],
            'nb_places' => ['required', 'integer'],
            'start_at' => ['required'],
        ]);

        $event = new Event();

        $event->title = $request->title;
        $event->desc = $request->desc;
        $event->address = $request->address;
        $event->link = $request->link;
        $event->nb_places = $request->nb_places;
        $event->start_at = $request->start_at;

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
        
        $event->image_id = $media->id;
        $event->save();

        return redirect()->route('events.index')->with('status', "$event->title was created.");
    }

    public function edit(Event $event)
    {
        $event = Event::findOrFail($event->id);
        return view('admin.events.edit', ['event' => $event]);
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'desc' => ['required', 'string'],
            'address' => ['required', 'string'],
            'link' => ['required', 'string', 'url'],
            'image' => ['image', 'mimes:jpeg,png,jpg,webp'],
            'nb_places' => ['required', 'integer'],
            'start_at' => ['required'],
        ]);

        $event->title = $request->title;
        $event->desc = $request->desc;
        $event->address = $request->address;
        $event->link = $request->link;
        $event->nb_places = $request->nb_places;
        $event->start_at = $request->start_at;
        
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
            
            $event->image_id = $media->id;
        }

        $event->save();

        return redirect()->route('events.index')->with('status', "$event->title a été édité.");
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('events.index')->with('status', "$event->title a été supprimé.");
    }
}
