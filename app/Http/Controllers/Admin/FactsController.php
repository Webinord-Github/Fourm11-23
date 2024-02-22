<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Fact;
use Auth;

class FactsController extends Controller
{
    public function index()
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
            'desc' => ['required', 'string'],
            'source_name' => ['required', 'string', 'max:255'],
            'source_url' => ['required', 'string', 'url']
        ]);

        $fact = new Fact();
        $fact->desc = $request->desc;
        $fact->source_name = $request->source_name;
        $fact->source_url = $request->source_url;
        $fact->save();

        return redirect()->route('facts.index')->with('status', "Votre saviez-vous a été créé.");
    }

    public function edit(Fact $fact)
    {
        return view('admin.facts.edit', ['fact' => $fact]);
    }

    public function update(Request $request, Fact $fact)
    {
        $request->validate([
            'desc' => ['required', 'string'],
            'source_name' => ['required', 'string', 'max:255'],
            'source_url' => ['required', 'string', 'url']
        ]);

        $fact->desc = $request->desc;
        $fact->source_name = $request->source_name;
        $fact->source_url = $request->source_url;
        $fact->save();


        return redirect()->route('facts.index')->with('status', "Votre saviez-vous a été modifié.");
    }

    public function destroy(Fact $fact)
    {
        $fact->delete();

        return redirect()->route('facts.index')->with('status', "Votre saviez-vous a été supprimé.");
    }
}
