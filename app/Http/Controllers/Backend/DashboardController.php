<?php

namespace App\Http\Controllers\Backend;

use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\Order;
use App\Models\Category;
use App\Models\Value;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index()
    {
        $pc = Product::count();
        $oc = Order::count();
        $cc = Category::count();
        $values = Value::all();
        $stocks_notification = ProductVariation::with('product')->orderBy('stock', 'asc')->take(10)->get();
        $orders_notification = Order::where('status', 'created')->get();
        return view('backend.dashboard', [
            'values' => $values,
            'products_count' => $pc,
            'orders_count' => $oc,
            'categories_count' => $cc,
            'stocks_notification' => $stocks_notification,
            'orders_notification' => $orders_notification
        ]);
    }
}
