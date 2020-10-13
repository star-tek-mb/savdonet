<?php

namespace App\Http\Controllers\Backend;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::all();
        return view('backend.categories', ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'title' => 'required|array',
            'title.*' => 'required',
            'photo' => 'required|image'
        ])->validate();

        $translations = $request->input('title');
        $photo_url = $request->file('photo')->store('upload', 'public');
        $category = new Category([
            'parent_id' => $request->input('parent_id'),
            'photo_url' => $photo_url
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
