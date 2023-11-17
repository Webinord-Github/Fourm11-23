<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function categories()
    {
        return view('admin.categories.index', ['categories' => Category::all()]);
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->save();

        return redirect('/admin/categories')->with('status', "$category->name a été créé.");
    }

    public function update($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', ['category' => $category]);
    }

    public function storeUpdate(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $category = Category::findOrFail($request->id);
        $category->name = $request->name;
        $category->save();

        return redirect('/admin/categories')->with('status', "$category->name a été modifié.");
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        Category::destroy($id);

        return redirect('/admin/categories')->with('status', "$category->name a été supprimé.");
    }
}
