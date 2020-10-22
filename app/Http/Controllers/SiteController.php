<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Page;
use Illuminate\Http\Request;
use Validator;
use DB;

class SiteController extends Controller
{

    public function index()
    {
        $categories = Category::whereNull('parent_id')->orderBy('number')->get();
        $pages = Page::orderBy('number')->get();
        return view('home', ['categories' => $categories, 'pages' => $pages]);
    }

    function paginateCollection($items, $perPage = 15, $page = null) {
        $page = $page ?: (\Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPage('page') ?: 1);
        $items = $items instanceof \Illuminate\Support\Collection ? $items : \Illuminate\Support\Collection::make($items);
        return new \Illuminate\Pagination\LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, [
            'path' => \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPath()
        ]);
    }

    public function page($slug) {
        $categories = Category::whereNull('parent_id')->orderBy('number')->get();
        $pages = Page::orderBy('number')->get();
        $page = Page::where('slug', $slug)->firstOrFail();
        return view('page', ['categories' => $categories, 'pages' => $pages, 'page' => $page]);
    }

    public function category($id, Request $request) {
        $pages = Page::orderBy('number')->get();
        $categories = Category::whereNull('parent_id')->orderBy('number')->get();
        $category = Category::findOrFail($id);
        $products = $this->paginateCollection($category->productsAll());
        return view('category', ['categories' => $categories, 'pages' => $pages, 'category' => $category, 'products' => $products]);
    }

    public function product($id) {
        $pages = Page::orderBy('number')->get();
        $categories = Category::whereNull('parent_id')->orderBy('number')->get();
        $product = Product::findOrFail($id);
        $product->increment('views');
        return view('product', ['categories' => $categories, 'pages' => $pages, 'product' => $product]);
    }

    public function search(Request $request) {
        $pages = Page::orderBy('number')->get();
        $categories = Category::whereNull('parent_id')->orderBy('number')->get();
        $request->flash();

        $validator = Validator::make($request->all(), ['q' => 'required|string|min:2']);
        if ($validator->fails()) {
            return view('search', ['categories' => $categories, 'pages' => $pages, 'results' => []])->withErrors($validator);
        }

        $terms = '%' . $request->query('q') . '%';
        $locale = config('app.locale');
        $results = Product::whereRaw("lower(json_unquote(json_extract(title, '$.$locale'))) LIKE ?", trim(strtolower($terms)))->paginate();
        return view('search', ['categories' => $categories, 'pages' => $pages, 'results' => $results]);
    }
}