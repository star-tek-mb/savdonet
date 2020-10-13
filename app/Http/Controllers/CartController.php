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

    private $regions = array(
        "Город Ташкент",
        "Андижанская область",
        "Бухарская область",
        "Джизакская область",
        "Кашкадарьинская область",
        "Навоийская область",
        "Наманганская область",
        "Самаркандская область",
        "Сурхандарьинская область",
        "Сырдарьинская область",
        "Ташкентская область",
        "Ферганская область",
        "Хорезмская область",
        "Республика Каракалпакстан"
    );

    public function index()
    {
        $categories = Category::whereNull('parent_id')->get();
        $values = Value::all();
        $cart = session()->get('cart') ?? array();
        return view('cart', [
            'cart' => $cart,
            'values' => $values,
            'categories' => $categories,
            'regions' => $this->regions
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
        return redirect()->back()->with('message', __('Cart cleared!'));;
    }

    public function makeOrder(Request $request) {
        Validator::make($request->all(), [
            'fullname' => 'required|string|max:512',
            'email' => 'required|string|email|max:512',
            'phone' => 'required|regex:/(\+998)[0-9]{9}$/',
            'address' => 'required|string|max:512',
            'comment' => 'required|string|max:1024',
            'region_city' => [
                'required',
                Rule::in($this->regions)
            ]
        ])->validate();
        $cart = session()->get('cart') ?? array();
        if (count($cart) <= 0) {
            return redirect()->back()->with('message', __('Cart is empty!'));
        }
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        $order = new Order($request->except('fullname'));
        $order->name = $request->input('fullname');
        $order->delivery_price = $settings['delivery_price'];
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
        }
        return redirect()->back()->with('message', __('Thanks for your order!'));
    }
}
