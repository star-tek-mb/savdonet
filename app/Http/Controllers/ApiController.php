<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ApiController extends Controller
{

    public function mainCategories()
    {
        return Category::whereNull('parent_id')->get();
    }

    public function subCategories($id)
    {
        return Category::where('parent_id', $id)->get();
    }

    function paginateCollection($items, $perPage = 15, $page = null, $options = []) {
        $page = $page ?: (\Illuminate\Pagination\Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof \Illuminate\Support\Collection ? $items : \Illuminate\Support\Collection::make($items);
        return new \Illuminate\Pagination\Paginator($items->forPage($page, $perPage), $perPage, $page, $options);
    }

    public function allProducts($id) {
        return $this->paginateCollection(Category::findOrFail($id)->productsAll());
    }

    public function latestProducts() {
        return Product::with('variations')->latest()->simplePaginate();
    }
}
