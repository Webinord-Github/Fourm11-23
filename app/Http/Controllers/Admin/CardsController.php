<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Card;
use App\Models\CardSection;

class CardsController extends Controller
{
    public function cards() 
    {
        return view('admin.cards.index', ['cards' => Card::all()]);
    }

    public function create() 
    {
        return view('admin.cards.create', ['sections' => CardSection::all()]);
    }

    public function store(Request $request) 
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'desc' => ['required', 'string'],
            'section_id' => ['required', 'integer'],
        ]);

        $card = new Card();

        $card->title = $request->title;
        $card->desc = $request->desc;
        $card->section_id = $request->section_id;

        $card->save();

        return redirect('/admin/cards')->with('status', "$card->title a été créé.");
    }

    public function update($id) 
    {
        $card = Card::findOrFail($id);
        return view('admin.cards.edit', ['card' => $card, 'sections' => CardSection::all()]);
    }

    public function storeUpdate(Request $request) 
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'desc' => ['required', 'string'],
            'section_id' => ['required', 'integer'],
        ]);

        $card = Card::findOrFail($request->id);

        $card->title = $request->title;
        $card->desc = $request->desc;
        $card->section_id = $request->section_id;

        $card->save();

        return redirect('/admin/cards')->with('status', "$card->title a été modifié.");
    }

    public function destroy($id) 
    {
        $card = Card::findOrFail($id);
        Card::destroy($id);

        return redirect('/admin/cards')->with('status', "$card->title a été supprimé.");
    }
}
