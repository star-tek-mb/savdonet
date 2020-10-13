<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    protected $fillable = ['product_id', 'stock', 'price', 'photo_url', 'values', 'sale_price', 'sale_start', 'sale_end'];
    protected $casts = ['values' => 'array', 'sale_start' => 'datetime', 'sale_end' => 'datetime'];
    public $timestamps = false;

    public function product() {
        return $this->belongsTo('App\Models\Product');
    }
}
