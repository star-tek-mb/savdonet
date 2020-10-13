<?php

namespace App\Http\Controllers\Backend;

use App\Models\Order;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;

class OrderController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return Datatables::eloquent(Order::query())->addIndexColumn()
                ->editColumn('status', function($row) {
                    return __($row->status);
                })->addColumn('total', function($row) {
                    $total = $row->delivery_price;
                    foreach ($row->products as $order_product) {
                        $total += $order_product->price * $order_product->quantity;
                    }
                    return $total . ' сум';
                })->addColumn('action', function($row) {
                    return view('backend.orders.datatables-action', ['order' => $row]);
                })->rawColumns(['total', 'action'])->make(true);
        }
        return view('backend.orders.index');
    }

}
