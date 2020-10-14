<?php

namespace App\Http\Controllers\Backend;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\Option;
use App\Models\Value;
use App\Models\Supplier;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use DataTables;
use Storage;
use Validator;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return Datatables::eloquent(Product::query())
                ->editColumn('title', function($row) {
                    return $row->title;
                })->addColumn('category', function($row) {
                    return $row->category->full_name;
                })->addColumn('supplier', function($row) {
                    return $row->supplier ? $row->supplier->shop_name : __('Not set');
                })->addColumn('image', function($row) {
                    return view('backend.products.datatables-carousel', ['product' => $row]);
                })->addColumn('price', function($row) {
                    return $row->variations[0]->price;
                })->addColumn('stock', function($row) {
                    return $row->variations[0]->stock;
                })->addColumn('action', function($row) {
                    return view('backend.products.datatables-action', ['product' => $row]);
                })->rawColumns(['category', 'supplier', 'image', 'action', 'price', 'stock'])->make(true);
        }
        return view('backend.products.index');
    }

    public function createSingle()
    {
        $categories = Category::all()->sortBy('full_name');
        $suppliers = Supplier::all();
        return view('backend.products.create-single', ['categories' => $categories, 'suppliers' => $suppliers]);
    }

    public function createVariable()
    {
        $categories = Category::all()->sortBy('full_name');
        $options = Option::all();
        $suppliers = Supplier::all();
        return view('backend.products.create-variable', ['categories' => $categories, 'options' => $options, 'suppliers' => $suppliers]);
    }

    public function store(Request $request) {
        $translations_title = $request->input('title');;
        $translations_description = $request->input('description');

        if ($request->has('options')) {
            Validator::make($request->all(), [
                'title' => 'required|array',
                'title.*' => 'required',
                'options' => 'required|array|min:1',
                'options.*' => 'required',
                'description' => 'required|array',
                'description.*' => 'required',
                'category_id' => 'required',
                'supplier_id' => 'nullable|int',
                'price' => 'required|array',
                'price.*' => 'required|integer|min:1',
                'stock' => 'required|array',
                'stock.*' => 'required|integer|min:1',
                'values' => 'required|array',
                'photo' => 'required|array',
                'photo.*' => 'required|image'
            ])->validate();

            $product = new Product([
                'category_id' => $request->input('category_id'),
                'supplier_id' => $request->input('supplier_id'),
                'options' => $request->input('options')
            ]);
            $product->setTranslations('title', $translations_title);
            $product->setTranslations('description', $translations_description);
            $product->save();

            for ($i = 0; $i < count($request->input('values')); $i++) {
                $photo_url = $request->file('photo')[$i]->store('upload', 'public');
                $values = explode(',', $request->input('values')[$i]);
                $product_variation = new ProductVariation([
                    'product_id' => $product->id,
                    'stock' => $request->input('stock')[$i],
                    'price' => $request->input('price')[$i],
                    'values' => $values,
                    'photo_url' => $photo_url
                ]);
                $product_variation->save();
            }
        } else {

            Validator::make($request->all(), [
                'title' => 'required|array',
                'title.*' => 'required',
                'description' => 'required|array',
                'description.*' => 'required',
                'category_id' => 'required|int',
                'supplier_id' => 'nullable|int',
                'price' => 'required|integer|min:1',
                'stock' => 'required|integer|min:1',
                'photo' => 'required|image'
            ])->validate();

            $photo_url = $request->file('photo')->store('upload', 'public');
            $product = new Product([
                'category_id' => $request->input('category_id'),
                'supplier_id' => $request->input('supplier_id'),
                'options' => array()
            ]);
            $product->setTranslations('title', $translations_title);
            $product->setTranslations('description', $translations_description);
            $product->save();

            $product_variation = new ProductVariation([
                'product_id' => $product->id,
                'stock' => $request->input('stock'),
                'price' => $request->input('price'),
                'values' => array(),
                'photo_url' => $photo_url
            ]);
            $product_variation->save();
        }
        return redirect()->back()->with('status', __('Product saved!'));
    }

    public function edit($id) {
        $product = Product::findOrFail($id);
        $categories = Category::all()->sortBy('full_name');
        $options = Option::all();
        $values = Value::all();
        $suppliers = Supplier::all();
        if ($product->options) {
            return view('backend.products.edit-variable', ['product' => $product, 'categories' => $categories, 'options' => $options, 'values' => $values, 'suppliers' => $suppliers]);
        } else {
            return view('backend.products.edit-single', ['product' => $product, 'categories' => $categories, 'suppliers' => $suppliers]);
        }
    }

    public function update($id, Request $request) {
        Validator::make($request->all(), [
            'title' => 'required|array',
            'title.*' => 'required',
            'description' => 'required|array',
            'description.*' => 'required',
            'category_id' => 'required',
            'supplier_id' => 'nullable|int',
            'price' => 'required|array',
            'price.*' => 'required|integer|min:1',
            'stock' => 'required|array',
            'stock.*' => 'required|integer|min:1',
            'photo' => 'nullable|array',
            'photo.*' => 'nullable|image',
            'sale_price' => 'required|array',
            'sale_price.*' => 'nullable|integer|min:1'
        ])->validate();

        $product = Product::findOrFail($id);
        // edit main product, we are not editing options and values
        $translations_title = $request->input('title');
        $translations_description = $request->input('description');
        $product->fill([
            'category_id' => $request->input('category_id'),
            'supplier_id' => $request->input('supplier_id')
        ]);
        $product->setTranslations('title', $translations_title);
        $product->setTranslations('description', $translations_description);
        $product->save();
        // edit its variation
        for ($i = 0; $i < count($request->input('variation')); $i++) {
            $variation = ProductVariation::findOrFail($request->input('variation')[$i]);
            // check photo uploaded, delete old if true
            $photo_url = $variation->photo_url;
            if ($request->file('photo') && array_key_exists($i, $request->file('photo'))) {
                Storage::disk('public')->delete($variation->photo_url);
                $photo_url = $request->file('photo')[$i]->store('upload', 'public');
            }
            // fill
            $variation->fill([
                'stock' => $request->input('stock')[$i],
                'price' => $request->input('price')[$i],
                'photo_url' => $photo_url
            ]);
            // fill sale price
            if ($request->input('sale_price')[$i]) {
                // parse date range TODO: validate?
                $sale_dates = explode(' - ', $request->input('sale_dates')[$i]);
                $sale_start = Carbon::createFromFormat('d.m.Y', $sale_dates[0]);
                $sale_end = Carbon::createFromFormat('d.m.Y', $sale_dates[1]);
                $sale_end->hour = 23;
                $sale_end->minute = 59;
                // fill price
                $variation->fill([
                    'sale_price' => $request->input('sale_price')[$i],
                    'sale_start' => $sale_start,
                    'sale_end' => $sale_end
                ]);
            }
            $variation->save();
        }
        return redirect()->back()->with('status', __('Product saved!'));
    }

    public function destroy($id) {
        $product = Product::findOrFail($id);
        foreach ($product->variations as $variation) {
            Storage::disk('public')->delete($variation->photo_url);
        }
        $product->delete();
        return redirect()->route('backend.products.index');
    }

    public function dropzoneUpload($id, Request $request) {
        Validator::make($request->all(), [
            'file' => 'image'
        ])->validate();
        $product = Product::findOrFail($id);
        $file_url = $request->file('file')->store('upload', 'public');
        $product->media = array_merge($product->media ?? array(), [$file_url]);
        $product->save();
        return response()->json([
            'status' => 200
        ]);
    }

    public function dropzoneInit($id, Request $request) {
        $product = Product::findOrFail($id);
        $res = array();
        foreach ($product->media as $media) {
            array_push($res, array(
                'file' => $media,
                'size' => Storage::disk('public')->size($media)
            ));
        }
        return response()->json([
            'status' => 200,
            'files' => $res
        ]);
    }

    public function dropzoneDelete($id, Request $request) {
        $product = Product::findOrFail($id);
        $product->media = array_diff($product->media, array($request->input('file')));
        $product->save();
        Storage::disk('public')->delete($request->input('file'));
        return response()->json([
            'status' => 200
        ]);
    }
}