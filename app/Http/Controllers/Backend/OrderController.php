<?php

namespace App\Http\Controllers\Backend;

use App\Models\Order;
use App\Models\Setting;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CartController;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{

    const statuses = [
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
                    return $row->total . ' ' . __('currency');
                })->addColumn('action', function($row) {
                    return view('backend.orders.datatables-action', ['order' => $row]);
                })->rawColumns(['total', 'action'])->make(true);
        }
        return view('backend.orders.index', ['statuses' => OrderController::statuses]);
    }

    public function show($id, Request $request) {
        $order = Order::findOrFail($id);
        return view('backend.orders.show', ['order' => $order, 'statuses' => OrderController::statuses]);
    }

    public function edit($id, Request $request) {
        $order = Order::findOrFail($id);
        return view('backend.orders.edit', ['order' => $order, 'statuses' => OrderController::statuses, 'delivery' => CartController::delivery, 'regions' => CartController::regions]);
    }

    public function update($id, Request $request) {
        Validator::make($request->all(), [
            'status' => [
                'nullable',
                Rule::in(OrderController::statuses)
            ]
        ])->validate();
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        $order = Order::findOrFail($id);
        $order->fill($request->all());
        $shipping_method = $request->input('delivery');
        $order->delivery_price = $settings['delivery_price' . ($shipping_method ? "_$shipping_method" : "")];
        $order->save();
        return redirect()->back()->with('status', __('Order updated!'));
    }
}