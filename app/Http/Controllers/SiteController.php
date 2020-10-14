<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Value;
use App\Models\Category;
use Illuminate\Http\Request;
use Validator;
use DB;

class SiteController extends Controller
{

    public function index()
    {
        $categories = Category::whereNull('parent_id')->get();
        return view('home', ['categories' => $categories]);
    }

    function paginateCollection($items, $perPage = 15, $page = null) {
        $page = $page ?: (\Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPage('page') ?: 1);
        $items = $items instanceof \Illuminate\Support\Collection ? $items : \Illuminate\Support\Collection::make($items);
        return new \Illuminate\Pagination\LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, [
            'path' => \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPath()
        ]);
    }

    public function category($id, Request $request) {
        $categories = Category::whereNull('parent_id')->get();
        $category = Category::findOrFail($id);
        $products = $this->paginateCollection($category->productsAll());
        return view('category', ['categories' => $categories, 'category' => $category, 'products' => $products]);
    }

    public function product($id) {
        $categories = Category::whereNull('parent_id')->get();
        $product = Product::findOrFail($id)->load('variations');
        $values = Value::all()->load('option');
        return view('product', ['categories' => $categories, 'product' => $product, 'values' => $values]);
    }

    public function search(Request $request) {
        $categories = Category::whereNull('parent_id')->get();
        $request->flash();

        $validator = Validator::make($request->all(), ['q' => 'required|string|min:2']);
        if ($validator->fails()) {
            return view('search', ['categories' => $categories, 'results' => []])->withErrors($validator);
        }

        $terms = '%' . $request->query('q') . '%';
        $locale = config('app.locale');
        $results = Product::whereRaw("lower(json_unquote(json_extract(title, '$.$locale'))) LIKE ?", trim(strtolower($terms)))->paginate(1);
        return view('search', ['categories' => $categories, 'results' => $results]);
    }
}
