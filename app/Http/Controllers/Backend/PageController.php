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
        Page::create($request->all());
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

        $page = Page::findOrFail($id);
        $page->fill($request->all())->save();
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