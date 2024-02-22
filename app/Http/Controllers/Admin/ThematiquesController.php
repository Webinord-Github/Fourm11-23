<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Thematique;
use Illuminate\Http\Request;

class ThematiquesController extends Controller
{
    public function index()
    {
        return view('admin.thematiques.index', ['thematiques' => Thematique::all()]);
    }

    public function create()
    {
        return view('admin.thematiques.create');
    }
    

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'desc' => ['required', 'string'],
        ]);

        $thematique = new Thematique();
        $thematique->name = $request->name;
        $thematique->desc = $request->desc;
        $thematique->save();

        return redirect()->route('thematiques.index')->with('status', "$thematique->name a été créé.");
    }

    public function edit(Thematique $thematique)
    {
        return view('admin.thematiques.edit', ['thematique' => $thematique]);
    }

    public function update(Request $request, Thematique $thematique)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'desc' => ['required', 'string'],
        ]);

        $thematique->name = $request->name;
        $thematique->desc = $request->desc;
        $thematique->save();

        return redirect()->route('thematiques.index')->with('status', "$thematique->name a été modifié.");
    }

    public function destroy(Thematique $thematique)
    {
        $thematique->delete();

        return redirect()->route('thematiques.index')->with('status', "$thematique->name a été supprimé.");
    }
}
