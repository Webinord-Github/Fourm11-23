<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Thematique;
use Illuminate\Http\Request;

class ThematiquesController extends Controller
{
    public function thematiques()
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
        ]);

        $thematique = new Thematique();
        $thematique->name = $request->name;
        $thematique->save();

        return redirect('/admin/thematiques')->with('status', "$thematique->name a été créé.");
    }

    public function update($id)
    {
        $thematique = Thematique::findOrFail($id);
        return view('admin.thematiques.edit', ['thematique' => $thematique]);
    }

    public function storeUpdate(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $thematique = Thematique::findOrFail($request->id);
        $thematique->name = $request->name;
        $thematique->save();

        return redirect('/admin/thematiques')->with('status', "$thematique->name a été modifié.");
    }

    public function destroy($id)
    {
        $thematique = Thematique::find($id);
        Thematique::destroy($id);

        return redirect('/admin/thematiques')->with('status', "$thematique->name a été supprimé.");
    }
}
