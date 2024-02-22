<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Media;
use App\Models\Notification;
use Illuminate\Support\Facades\Mail;
use App\Mail\AutoEmail;
use App\Models\eventBookmark;
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
        $validatedData = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'desc' => ['required', 'string'],
            'address' => ['required', 'string'],
            'link' => ['required', 'string'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,webp'],
            'start_at' => ['required'],
        ]);

        $event = new Event();

        $event->title = $validatedData['title'];
        $event->desc = $validatedData['desc'];
        $event->address = $validatedData['address'];
        $event->link = $validatedData['link'];
        $event->start_at = $validatedData['start_at'];
        $event->published = true;
        $event->notified = true;

        $file_original_name = $request->image->getClientOriginalName();
        $file_name_only = pathinfo($file_original_name, PATHINFO_FILENAME);
        $file_provider = pathinfo($file_original_name, PATHINFO_EXTENSION);
        $file_size = $request->image->getSize() / 1024;
        $existing_file_url = Media::where('name', '=', $file_original_name)->first();
        $count_file = Media::where('original_name', '=', $file_original_name)->count();

        if ($existing_file_url) {
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
        Storage::putFileAs('public/medias', $request->image, $file_name);

        $event->image_id = $media->id;
        $event->save();

        $notification = new Notification();
        $notification->sujet = 'Nouvel événement ajouté:<br> ' . '<span style="font-size:12px">' . $validatedData['title'] . '</span>';
        $notification->notif_link = '/';
        $notification->type = "BasicNotif";
        $notification->save();

        return redirect()->route('events.index')->with('status', "L'événement $event->title a été créé.");
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
            'link' => ['required', 'string'],
            'image' => ['image', 'mimes:jpeg,png,jpg,webp'],
            'start_at' => ['required'],
        ]);

        $event->title = $request->title;
        $event->desc = $request->desc;
        $event->address = $request->address;
        $event->link = $request->link;
        $event->start_at = $request->start_at;

        if ($request->hasFile('image')) {
            $file_original_name = $request->image->getClientOriginalName();
            $file_name_only = pathinfo($file_original_name, PATHINFO_FILENAME);
            $file_provider = pathinfo($file_original_name, PATHINFO_EXTENSION);
            $file_size = $request->image->getSize() / 1024;
            $existing_file_url = Media::where('name', '=', $file_original_name)->first();
            $count_file = Media::where('original_name', '=', $file_original_name)->count();

            if ($existing_file_url) {
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
            Storage::putFileAs('public/medias', $request->image, $file_name);

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

    public function userAddEvent(Request $request)
    {
        $validatedData = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'desc' => ['required', 'string'],
            'address' => ['required', 'string'],
            'link' => ['required', 'string'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,webp'],
            'start_at' => ['required'],
        ]);

        $event = new Event();

        $event->title = $validatedData['title'];
        $event->desc = $validatedData['desc'];
        $event->address = $validatedData['address'];
        $event->link = $validatedData['link'];
        $event->start_at = $validatedData['start_at'];
        $event->published = false;
        $event->notified = false;

        $file_original_name = $request->image->getClientOriginalName();
        $file_name_only = pathinfo($file_original_name, PATHINFO_FILENAME);
        $file_provider = pathinfo($file_original_name, PATHINFO_EXTENSION);
        $file_size = $request->image->getSize() / 1024;
        $existing_file_url = Media::where('name', '=', $file_original_name)->first();
        $count_file = Media::where('original_name', '=', $file_original_name)->count();

        if ($existing_file_url) {
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
        Storage::putFileAs('public/medias', $request->image, $file_name);

        $event->image_id = $media->id;
        $event->save();

        $to_email = 'info@webinord.ca';
        $emailBody = "
        <h1 style='text-align:center;'>
        La fourmilière</h1>
        <p>Nouvel événement ajouté par un.e utilisateur.trice</p>
        <p><strong>Titre:</strong> " . $validatedData['title'] .  "</p>
        <p><strong>Nom de l'utilisateur:</strong> " . Auth::user()->firstname . " " . Auth::user()->lastname . "</p>
        <p><strong>Courriel de l'utilisateur:</strong> " . Auth::user()->email . "</p>
        
        ";
        $customSubject = 'Nouvel événement';
        Mail::to($to_email)->send(new AutoEmail($emailBody, $customSubject));

        return back()->with('status', 'Évnément Soumis. Un/une administrateur.trice revisera votre demande. Merci!');
    }

    public function eventsPublished(Request $request)
    {
        foreach ($request->input('event_ids') as $eventId) {
            $event = Event::find($eventId);
            $isChecked = $request->has('checkbox_' . $eventId);

            // Update the 'published' attribute based on checkbox status
        
            $event->published = $isChecked;

            if ($event->notified == false) {
                $event->notified = true;
                $notification = new Notification();
                $notification->sujet = 'Nouvel événement ajouté:<br> ' . '<span style="font-size:12px">' . $event->title . '</span>';
                $notification->notif_link = '/';
                $notification->type = "BasicNotif";
                $notification->save();
            }
            $event->save();
        }

        return redirect()->route('events.index')->with('success', 'Les événements ont été mis à jour.');
    }

    public function eventBookmarks(Request $request)
    {
        $validatedData = $request->validate([
            'eventid' => ['numeric'],
        ]);

        $existingBookmark = eventBookmark::where('event_id', $validatedData['eventid'])
        ->where('user_id', Auth::user()->id)->first();
        if(!$existingBookmark) {
            $newBookmark = new eventBookmark();
            $newBookmark->event_id = $validatedData['eventid'];
            $newBookmark->user_id = Auth::user()->id;
            $newBookmark->save();
        } else {
            $existingBookmark->delete();
        }

        return response()->json([
            'message' => 'true',
        ]);
    }
}
