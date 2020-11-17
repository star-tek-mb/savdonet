<?php

namespace App\Http\Controllers\Backend;

use App\Constants;
use App\Models\Order;
use App\Models\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use DataTables;
use DB;

class OrderController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return Datatables::eloquent(Order::with('products'))->addIndexColumn()
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
        $counts = [
            Order::with('products')->where('status', 'created')->count(),
            Order::with('products')->where('status', 'processing')->count(),
            Order::with('products')->where('status', 'confirmed')->count(),
            Order::with('products')->where('status', 'shipped')->count(),
            Order::with('products')->where('status', 'delivered')->count(),
            Order::with('products')->where('status', 'rejected')->count()
        ];
        $totals = [
            Order::with('products')->where('status', 'created')->get()->sum('total'),
            Order::with('products')->where('status', 'processing')->get()->sum('total'),
            Order::with('products')->where('status', 'confirmed')->get()->sum('total'),
            Order::with('products')->where('status', 'shipped')->get()->sum('total'),
            Order::with('products')->where('status', 'delivered')->get()->sum('total'),
            Order::with('products')->where('status', 'rejected')->get()->sum('total')
        ];
        return view('backend.orders.index', ['statuses' => Constants::STATUSES, 'counts' => $counts, 'totals' => $totals]);
    }

    public function show($id, Request $request) {
        $order = Order::findOrFail($id);
        return view('backend.orders.show', ['order' => $order, 'statuses' => Constants::STATUSES]);
    }

    public function edit($id, Request $request) {
        $order = Order::findOrFail($id);
        return view('backend.orders.edit', ['order' => $order, 'statuses' => Constants::STATUSES, 'delivery' => Constants::DELIVERY_METHODS, 'regions' => Constants::REGIONS]);
    }

    public function update($id, Request $request) {
        Validator::make($request->all(), [
            'status' => [
                'nullable',
                Rule::in(Constants::STATUSES)
            ]
        ])->validate();
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        $order = Order::findOrFail($id);

        // if editing status to rejected - increment stocks
        if ($request->input('status') == 'rejected' && $order->status != 'rejected') {
            foreach ($order->products as $orderProduct) {
                if ($orderProduct->item) { // if exists
                    $orderProduct->item->increment('stock', $orderProduct->quantity);
                }
            }
        }
        // if editing status from rejected - decrement stocks
        if ($order->status == 'rejected' && $request->input('status') != 'rejected') {
            foreach ($order->products as $orderProduct) {
                if ($orderProduct->item) { // if exists
                    $orderProduct->item->decrement('stock', $orderProduct->quantity);
                }
            }
        }

        $order->fill($request->all());
        $shipping_method = $request->input('delivery');
        $order->delivery_price = $settings['delivery_price' . ($shipping_method ? "_$shipping_method" : "")];
        $order->save();

        return redirect()->back()->with('status', __('Order updated!'));
    }
}
