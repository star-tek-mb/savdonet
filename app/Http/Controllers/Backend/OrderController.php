<?php

namespace App\Http\Controllers\Backend;

use App\Models\Order;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{

    private $statuses = [
        'created',
        'processing',
        'confirmed',
        'shipped',
        'delivered',
        'rejected'
    ];

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return Datatables::eloquent(Order::query())->addIndexColumn()
                ->editColumn('status', function($row) {
                    return __($row->status);
                })->editColumn('region', function($row) {
                    return __($row->region);
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

    public function show($id, Request $request) {
        $order = Order::findOrFail($id);
        return view('backend.orders.show', ['order' => $order, 'statuses' => $this->statuses]);
    }

    public function updateStatus($id, Request $request) {
        Validator::make($request->all(), [
            'status' => [
                'required',
                Rule::in($this->statuses)
            ]
        ])->validate();
        $order = Order::findOrFail($id);
        $order->status = $request->input('status');
        $order->save();
        return redirect()->back()->with('status', __('Status updated!'));
    }
}
