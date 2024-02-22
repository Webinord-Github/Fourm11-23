<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tool;

class ToolsGuardController extends Controller
{
    public function index()
    {
        $tools = Tool::all();

        return view('admin.toolsguard.index', ['tools' => $tools]);
    }


    public function store(Request $request)
    {
        foreach($request->input('tool_ids') as $tool_id) {
            $tool = Tool::find($tool_id);
            if ($request->has('checkbox_'.$tool_id)) {
                $tool->verified = true;
            } else {
                $tool->verified = false;
            }
            $tool->save();
        }
    
        return redirect()->route('toolsguard.index')->with('success', 'Les outils ont été mis à jour.');
    }
}
