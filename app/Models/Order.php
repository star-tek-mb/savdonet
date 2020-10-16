<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['delivery_price', 'name', 'email', 'phone', 'region', 'city', 'address', 'comment', 'delivery', 'status'];

    public function products() {
        return $this->hasMany('App\Models\OrderProduct');
    }

    public function getTotalAttribute() {
        $total = $this->delivery_price ?? 0;
        foreach ($this->products as $order_product) {
            $total += $order_product->price * $order_product->quantity;
        }
        return $total;
    }
}
