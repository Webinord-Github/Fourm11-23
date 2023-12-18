<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Media;
use App\Models\Fact;
use Illuminate\Support\Facades\Storage;
use Auth;

class FactsController extends Controller
{
    public function facts()
    {
        return view('admin.facts.index', ['facts' => Fact::all()]);
    }

    public function create()
    {
        return view('admin.facts.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'desc' => ['required', 'string'],
            'img' => ['required', 'image', 'mimes:jpeg,png,jpg,webp'],
            'url' => ['required', 'string', 'url']
        ]);

        $fact = new Fact();

        $fact->title = $request->title;
        $fact->desc = $request->desc;
        $fact->url = $request->url;

        $file_original_name = $request->img->getClientOriginalName();
        $file_name_only = pathinfo($file_original_name, PATHINFO_FILENAME);
        $file_provider = pathinfo($file_original_name, PATHINFO_EXTENSION);
        $file_size = $request->img->getSize() / 1024;
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
        Storage::putFileAs('public/medias',$request->img, $file_name);
        
        $fact->image_id = $media->id;
        $fact->save();

        return redirect('/admin/facts')->with('status', "$fact->title a été créé.");
    }

    public function update($id)
    {
        $fact = Fact::findOrFail($id);
        return view('admin.facts.edit', ['fact' => $fact]);
    }

    public function storeUpdate(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'desc' => ['required', 'string'],
            'img' => ['image', 'mimes:jpeg,png,jpg,webp'],
            'url' => ['required', 'string']
        ]);

        $fact = Fact::findOrFail($request->id);

        $fact->title = $request->title;
        $fact->desc = $request->desc;
        $fact->url = $request->url;

        if($request->img) {
            $file_original_name = $request->img->getClientOriginalName();
            $file_name_only = pathinfo($file_original_name, PATHINFO_FILENAME);
            $file_provider = pathinfo($file_original_name, PATHINFO_EXTENSION);
            $file_size = $request->img->getSize() / 1024;
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
            Storage::putFileAs('public/medias',$request->img, $file_name);
            
            $fact->image_id = $media->id;
        }


        $fact->save();

        return redirect('/admin/facts')->with('status', "$fact->title a été modifié.");
    }

    public function destroy($id)
    {
        $fact = Fact::findOrFail($id);
        Fact::destroy($id);
        $fact->categories()->detach();

        return redirect('/admin/facts')->with('status', "$fact->title a été supprimé.");
    }
}
