<?php

namespace App\Http\Controllers\Backend;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Storage;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::all();
        return view('backend.categories.index', ['categories' => $categories]);
    }

    public function create()
    {
        $categories = Category::all()->sortBy('full_name');
        return view('backend.categories.create', ['categories' => $categories]);
    }

    public function edit($id, Request $request)
    {
        $category = Category::findOrFail($id);
        $categories = Category::all()->sortBy('full_name');
        return view('backend.categories.edit', ['category' => $category, 'categories' => $categories]);
    }

    public function update($id, Request $request)
    {
        Validator::make($request->all(), [
            'title' => 'required|array',
            'title.*' => 'required',
            'photo' => 'nullable|image',
            'number' => 'nullable|integer'
        ])->validate();

        $category = Category::findOrFail($id);
        $photo_url = $category->photo_url;
        if ($request->file('photo')) {
            Storage::disk('public')->delete($photo_url);
            $photo_url = $request->file('photo')->store('upload', 'public');
        }
        $category->fill([
            'parent_id' => $request->input('parent_id'),
            'photo_url' => $photo_url,
            'number' => $request->input('number') ?? 1
        ]);
        $translations = $request->input('title');
        $category->setTranslations('title', $translations);
        $category->save();
        return redirect()->back()->with('status', __('Category stored!'));
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'title' => 'required|array',
            'title.*' => 'required',
            'photo' => 'required|image',
            'number' => 'nullable|integer'
        ])->validate();

        $translations = $request->input('title');
        $photo_url = $request->file('photo')->store('upload', 'public');
        $category = new Category([
            'parent_id' => $request->input('parent_id'),
            'photo_url' => $photo_url,
            'number' => $request->input('number') ?? 1
        ]);
        $category->setTranslations('title', $translations);
        $category->save();
        return redirect()->back()->with('status', __('Category stored!'));
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        Storage::disk('public')->delete($category->photo_url);
        $category->delete();
        return redirect()->back()->with('status', __('Category deleted!'));
    }
}
