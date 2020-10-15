<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $fillable = ['order_id', 'product_variation_id', 'price', 'quantity'];
    public $timestamps = false;

    public function item() {
        return $this->belongsTo('App\Models\ProductVariation', 'product_variation_id');
    }
}
