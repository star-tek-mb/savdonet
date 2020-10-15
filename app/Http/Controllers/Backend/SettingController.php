<?php

namespace App\Http\Controllers\Backend;

use App\Models\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class SettingController extends Controller
{

    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        return view('backend.settings', ['settings' => $settings]);
    }

    public function store(Request $request)
    {
        Setting::query()->delete();
        $len = count($request->input('key'));
        for ($i = 0; $i < $len; $i++) {
            Setting::create([
                'key' => $request->input('key')[$i],
                'value' => $request->input('value')[$i]
            ]);
        }
        return redirect()->back()->with('status', __('Settings saved!'));
    }
}
