<?php

namespace App\Http\Controllers;

use App\Models\ProductVariation;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Value;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CartController extends Controller
{

    // TODO?
    private $regions = array(
        'andijan',
        'bukhara',
        'jizzakh',
        'qashqadaryo',
        'navoiy',
        'namangan',
        'samarqand',
        'surxondaryo',
        'sirdaryo',
        'tashkent',
        'fergana',
        'xorazm',
        'karakalpakstan'
    );

    private $delivery = array(
        'office',
        'courier',
        'courier_tashkent'
    );

    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        $categories = Category::whereNull('parent_id')->get();
        $values = Value::all();
        $cart = session()->get('cart') ?? array();

        // check if products exist
        foreach ($cart as $id => $cartItem) {
            if (ProductVariation::find($id) == null) {
                $cart = array();
                session()->put('cart', $cart);
                break;
            }
        }

        return view('cart', [
            'cart' => $cart,
            'values' => $values,
            'categories' => $categories,
            'regions' => $this->regions,
            'delivery' => $this->delivery,
            'settings' => $settings
        ]);
    }

    public function store(Request $request, $id)
    {
        $variation = ProductVariation::findOrFail($id)->load('product');
        $cart = session()->get('cart') ?? array();
        $quantity = $request->input('qty') ?? 1;
        if ($quantity > $variation->stock) {
            return redirect()->back()->with('status', __('Not in stock!'));
        }
        $cart[$id] = [
            'variation' => $variation,
            'quantity' => $quantity,
        ];
        if ($quantity <= 0) {
            unset($cart[$id]);
        }
        session()->put('cart', $cart);
        return redirect()->back()->with('status', __('Product added to your cart!'));
    }

    public function clear()
    {
        session()->put('cart', array());
        return redirect()->back()->with('status', __('Cart cleared!'));;
    }

    public function makeOrder(Request $request) {
        Validator::make($request->all(), [
            'fullname' => 'required|string|max:512',
            'email' => 'nullable|string|email|max:256',
            'phone' => 'required|regex:/(\+998)[0-9]{9}$/',
            'address' => 'required|string|max:512',
            'comment' => 'nullable|string|max:1024',
            'region' => [
                'required',
                Rule::in($this->regions)
            ],
            'city' => 'required|string|max:256',
            'delivery' => [
                'required',
                Rule::in($this->delivery)
            ]
        ])->validate();

        // check cart and stocks
        $cart = session()->get('cart') ?? array();
        if (count($cart) <= 0) {
            return redirect()->back()->with('status', __('Cart is empty!'));
        }
        foreach ($cart as $cartItem) {
            if ($cartItem['variation']->stock < $cartItem['quantity']) {
                return redirect()->back()->with('status', __('Not in stock!'));
            }
        }

        $settings = Setting::all()->pluck('value', 'key')->toArray();
        $order = new Order($request->except('fullname'));
        $order->name = $request->input('fullname');
        $order->delivery_price = $settings['delivery_price_' . $request->input('delivery')];
        $order->status = 'created';
        $order->save();
        foreach ($cart as $cartItem) {
            OrderProduct::create([
                'order_id' => $order->id,
                'product_variation_id' => $cartItem['variation']->id,
                'price' => $cartItem['variation']->price,
                'quantity' => $cartItem['quantity']
            ]);
            $cartItem['variation']->stock -= $cartItem['quantity'];
            $cartItem['variation']->save();
        }
        session()->put('cart', array()); // clear cart
        return redirect()->back()->with('status', __('Thanks for your order!'));
    }
}
