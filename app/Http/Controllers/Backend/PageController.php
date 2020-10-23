<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Page;
use Storage;

class PageController extends Controller
{

    public function index()
    {
        $pages = Page::all();
        return view('backend.pages.index', ['pages' => $pages]);
    }

    public function create()
    {
        return view('backend.pages.create');
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'slug' => 'required|unique:pages,slug|max:255',
            'number' => 'nullable|integer',
            'title' => 'required|array',
            'title.*' => 'required',
            'description' => 'required|array',
            'description.*' => 'required'
        ])->validate();

        $translations_title = $request->input('title');;
        $translations_description = $request->input('description');
        $page = new Page([
            'slug' => $request->input('slug'),
            'number' => $request->input('number') ?? 1
        ]);
        $page->setTranslations('title', $translations_title);
        $page->setTranslations('description', $translations_description);
        $page->save();
        return redirect()->back()->with('status', __('Page created!'));
    }

    public function edit($id)
    {
        $page = Page::findOrFail($id);
        return view('backend.pages.edit', ['page' => $page]);
    }

    public function update(Request $request, $id)
    {
        Validator::make($request->all(), [
            'slug' => 'required|unique:pages,slug,' . $id . '|max:255',
            'number' => 'nullable|integer',
            'title' => 'required|array',
            'title.*' => 'required',
            'description' => 'required|array',
            'description.*' => 'required'
        ])->validate();

        $translations_title = $request->input('title');;
        $translations_description = $request->input('description');
        $page = Page::findOrFail($id);
        $page->fill([
            'slug' => $request->input('slug'),
            'number' => $request->input('number') ?? 1
        ]);
        $page->setTranslations('title', $translations_title);
        $page->setTranslations('description', $translations_description);
        $page->save();
        return redirect()->back();
    }

    public function destroy($id)
    {
        $page = Page::findOrFail($id);
        $page->delete();
        Storage::disk('public')->deleteDirectory('upload/page' . $id);
        return redirect()->back();
    }

    public function uploadImage(Request $request, $id) {
        if ($request->hasFile('file')) {
            $path = 'upload/page' . $id;
            $url = Storage::url($request->file('file')->store($path, 'public'));
            return $url;
        }
        return '';
    }
}