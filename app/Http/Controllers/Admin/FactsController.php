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
            'url' => ['required', 'string']
        ]);

        $fact = new Fact();

        $fact->title = $request->title;
        $fact->desc = $request->desc;
        $fact->url = $request->url;

        $newFile = $request->img->getClientOriginalName();
        $newfile_info = pathinfo($newFile, PATHINFO_FILENAME);
        $newfile_info_ext = pathinfo($newFile, PATHINFO_EXTENSION);
        $existing_file_url = Media::where('base_path', '=', $newFile)->first();
        $count_file = Media::where('base_path', '=', $newFile)->count();
        $fileSize = $request->file('img')->getSize() / 1024;

        if($existing_file_url) {
            $file_iteration_url = $newfile_info . "_" . $count_file + 1 . "." . $newfile_info_ext;
            Storage::putFileAs('public/medias',$request->img, $file_iteration_url);
            Media::create([
                'url' => $file_iteration_url,
                'base_path' => $newFile,
                'description' => $request->description,
                'user_id' => Auth::user()->id,
                'file_size' => $fileSize,
                'provider' => $newfile_info_ext,
            ]);
            $fact->img = $file_iteration_url;
        } else {
            Media::create([
                'url' => $newFile,
                'base_path' => $newFile,
                'description' => $request->description,
                'user_id' => Auth::user()->id,
                'file_size' => $fileSize,
                'provider' => $newfile_info_ext,
            ]);
            Storage::putFileAs('public/medias',$request->img, $newFile);
            $fact->img = $newFile;
        }

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

        if($request->img != null) {
            $newFile = $request->img->getClientOriginalName();
            $newfile_info = pathinfo($newFile, PATHINFO_FILENAME);
            $newfile_info_ext = pathinfo($newFile, PATHINFO_EXTENSION);
            $existing_file_url = Media::where('base_path', '=', $newFile)->first();
            $count_file = Media::where('base_path', '=', $newFile)->count();
            $fileSize = $request->file('img')->getSize() / 1024;
    
            if($existing_file_url) {
                $file_iteration_url = $newfile_info . "_" . $count_file + 1 . "." . $newfile_info_ext;
                Storage::putFileAs('public/medias',$request->img, $file_iteration_url);
                Media::create([
                    'url' => $file_iteration_url,
                    'base_path' => $newFile,
                    'description' => $request->description,
                    'user_id' => Auth::user()->id,
                    'file_size' => $fileSize,
                    'provider' => $newfile_info_ext,
                ]);
                $fact->img = $file_iteration_url;
            } else {
                Media::create([
                    'url' => $newFile,
                    'base_path' => $newFile,
                    'description' => $request->description,
                    'user_id' => Auth::user()->id,
                    'file_size' => $fileSize,
                    'provider' => $newfile_info_ext,
                ]);
                Storage::putFileAs('public/medias',$request->img, $newFile);
                $fact->img = $newFile;
            }
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
