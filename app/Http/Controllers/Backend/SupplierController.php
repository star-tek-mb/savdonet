<?php

namespace App\Http\Controllers\Backend;

use App\Models\Supplier;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Storage;

class SupplierController extends Controller
{

    public function index()
    {
        $suppliers = Supplier::all();
        return view('backend.suppliers.index', ['suppliers' => $suppliers]);
    }

    public function create()
    {
        return view('backend.suppliers.create');
    }

    public function edit($id, Request $request)
    {
        $supplier = Supplier::findOrFail($id);
        return view('backend.suppliers.edit', ['supplier' => $supplier]);
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name' => 'required|string|max:512',
            'shop_name' => 'required|string|max:512',
            'address' => 'required|string|max:512',
            'phone' => 'required|string|max:32'
        ])->validate();
        Supplier::create($request->all());
        return redirect()->back()->with('status', __('Supplier stored!'));
    }

    public function update($id, Request $request)
    {
        Validator::make($request->all(), [
            'name' => 'required|string|max:512',
            'shop_name' => 'required|string|max:512',
            'address' => 'required|string|max:512',
            'phone' => 'required|string|max:32'
        ])->validate();
        Supplier::findOrFail($id)->fill($request->all());
        return redirect()->back()->with('status', __('Supplier stored!'));
    }

    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();
        return redirect()->back()->with('status', __('Supplier deleted!'));
    }
}
