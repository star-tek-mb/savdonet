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

}
