<?php

namespace App\Http\Controllers\Backend;

use App\Models\Option;
use App\Models\Value;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class OptionController extends Controller
{

    public function index()
    {
        $options = Option::all();
        return view('backend.options', ['options' => $options]);
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'title' => 'required|array',
            'title.*' => 'required'
        ])->validate();

        $translations = $request->input('title');
        $option = new Option;
        $option->setTranslations('title', $translations);
        $option->save();
        return redirect()->back()->with('status', __('Option stored!'));
    }

    public function update(Request $request, $id)
    {
        $option = Option::findOrFail($id);
        Validator::make($request->all(), [
            'title' => 'required|array',
            'title.*' => 'required'
        ])->validate();
        $translations = $request->input('title');
        $option->setTranslations('title', $translations);
        $option->save();
        return redirect()->back()->with('status', __('Option saved!'));
    }

    public function destroy($id)
    {
        $option = Option::findOrFail($id);
        $option->delete();
        return redirect()->back()->with('status', __('Option deleted!'));
    }

    public function storeValue(Request $request, $option_id)
    {
        Validator::make($request->all(), [
            'title' => 'required|array',
            'title.*' => 'required'
        ])->validate();

        $translations = $request->input('title');
        $value = new Value([
            'option_id' => $option_id
        ]);
        $value->setTranslations('title', $translations);
        $value->save();
        return redirect()->back()->with('status', __('Value stored!'));
    }

    public function updateValue(Request $request, $id)
    {
        $value = Value::findOrFail($id);
        Validator::make($request->all(), [
            'title' => 'required|array',
            'title.*' => 'required'
        ])->validate();
        $translations = $request->input('title');
        $value->setTranslations('title', $translations);
        $value->save();
        return redirect()->back()->with('status', __('Value saved!'));
    }

    public function destroyValue($id)
    {
        $value = Value::findOrFail($id);
        $value->delete();
        return redirect()->back()->with('status', __('Value deleted!'));
    }
}
