<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Auth;

class ToolsController extends Controller
{
    public function tools()
    {
        return view('admin.tools.index', ['tools' => Tool::all()]);
    }

    public function create()
    {
        return view('admin.tools.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'desc' => ['required', 'string'],
            'doc' => ['required', 'file', 'mimes:pdf,docx'],
            'status' => ['required', 'string']
        ]);

        $tool = new Tool();

        $tool->user_id = Auth::user()->id;
        $tool->title = $request->title;
        $tool->desc = $request->desc;
        $tool->status = $request->status;
        $tool->published_at = $request->published_at;

        $doc_ext =  $request->doc->extension();
        $doc_name = strtolower(preg_replace("/\s+/", "", $request->title));
        $doc_fullname = $doc_name . '.' . $doc_ext;
        Storage::putFileAs('public/doc/tools', $request->doc, $doc_fullname);
        $tool->doc = $doc_fullname;

        $tool->save();

        return redirect('/admin/tools')->with('status', "$tool->title was created.");
    }

    public function update($id)
    {
        $tool = Tool::findOrFail($id);
        return view('admin.tools.edit', ['tool' => $tool]);
    }

    public function storeUpdate(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'desc' => ['required', 'string'],
            'doc' => ['file', 'mimes:pdf,docx'],
            'status' => ['required', 'string']
        ]);

        $tool = Tool::findOrFail($request->id);

        $tool->title = $request->title;
        $tool->desc = $request->desc;
        $tool->status = $request->status;
        $tool->published_at = $request->published_at;

        $doc_name = strtolower(preg_replace("/\s+/", "", $request->title));
        if ($request->doc != null) {
            Storage::delete('public/doc/tools/' . $tool->doc);
            $doc_ext =  $request->doc->extension();
            $doc_fullname = $doc_name . '.' . $doc_ext;
            Storage::putFileAs('public/doc/tools', $request->doc, $doc_fullname);
        } else {
            $doc_ext = pathinfo(storage_path('public/doc/tools/' . $tool->doc), PATHINFO_EXTENSION);
            $doc_fullname = $doc_name . '.' . $doc_ext;
            Storage::move('public/doc/tools/' . $tool->doc, 'public/doc/tools/' . $doc_fullname);
        }
        $tool->doc = $doc_fullname;

        $tool->save();

        return redirect('/admin/tools')->with('status', "$tool->title was edited.");
    }

    public function destroy($id)
    {
        $tool = Tool::find($id);
        Tool::destroy($id);

        return redirect('/admin/tools')->with('status', "$tool->title was deleted.");
    }
}
