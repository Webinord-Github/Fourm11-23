<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tool;
use App\Models\Media;
use App\Models\Thematique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Auth;

class ToolsController extends Controller
{
    public function tools()
    {
        return view('admin.tools.index', ['tools' => Tool::all(), 'thematiques' => Thematique::all()]);
    }

    public function create()
    {
        return view('admin.tools.create', ['thematiques' => Thematique::all()]);
    }

    public function store(Request $request)
    {

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'desc' => ['required', 'string'],
            'doc' => ['required', 'file', 'mimes:pdf,docx'],
            'thematiques' => ['required', 'array'],
            'status' => ['required', 'string']
        ]);

        $tool = new Tool();

        $thematiques_selected = [];

        foreach ($request->thematiques as $thematique) {
            array_push($thematiques_selected, $thematique);
        }

        $tool->user_id = Auth::user()->id;
        $tool->title = $request->title;
        $tool->desc = $request->desc;
        $tool->status = $request->status;
        $tool->published_at = $request->published_at;

        $file_original_name = $request->doc->getClientOriginalName();
        $file_name_only = pathinfo($file_original_name, PATHINFO_FILENAME);
        $file_provider = pathinfo($file_original_name, PATHINFO_EXTENSION);
        $file_size = $request->doc->getSize() / 1024;
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
        Storage::putFileAs('public/medias',$request->doc, $file_name);

        $tool->doc_id = $media->id;
        $tool->save();
        $tool->thematiques()->sync($thematiques_selected);

        return redirect('/admin/tools')->with('status', "$tool->title a été créé.");
    }

    public function update($id)
    {
        $tool = Tool::findOrFail($id);
        $thematiques_selected = Tool::find($tool->id)->thematiques;
        return view('admin.tools.edit', ['tool' => $tool, 'thematiques' => Thematique::all(), 'thematiques_selected' => $thematiques_selected]);
    }

    public function storeUpdate(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'desc' => ['required', 'string'],
            'doc' => ['file', 'mimes:pdf,docx'],
            'thematiques' => ['required', 'array'],
            'status' => ['required', 'string']
        ]);

        $tool = Tool::findOrFail($request->id);

        $thematiques_selected = [];

        foreach ($request->thematiques as $thematique) {
            array_push($thematiques_selected, $thematique);
        }

        $tool->title = $request->title;
        $tool->desc = $request->desc;
        $tool->status = $request->status;
        $tool->published_at = $request->published_at;

        if($request->doc) {
            $file_original_name = $request->doc->getClientOriginalName();
            $file_name_only = pathinfo($file_original_name, PATHINFO_FILENAME);
            $file_provider = pathinfo($file_original_name, PATHINFO_EXTENSION);
            $file_size = $request->doc->getSize() / 1024;
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
            Storage::putFileAs('public/medias',$request->doc, $file_name);
    
            $tool->doc_id = $media->id;
        }

        $tool->save();
        $tool->thematiques()->sync($thematiques_selected);

        return redirect('/admin/tools')->with('status', "$tool->title a été édité.");
    }

    public function destroy($id)
    {
        $tool = Tool::find($id);
        Tool::destroy($id);
        $tool->thematiques()->detach();

        return redirect('/admin/tools')->with('status', "$tool->title a été supprimé.");
    }
}
