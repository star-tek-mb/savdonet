<?php

namespace App\Models;

use App\Models\Value;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class ProductVariation extends Model
{
    protected $fillable = ['product_id', 'sku', 'stock', 'price', 'photo_url', 'values', 'sale_price', 'sale_start', 'sale_end'];
    protected $casts = ['values' => 'array', 'sale_start' => 'datetime', 'sale_end' => 'datetime'];
    public $timestamps = false;

    public function product() {
        return $this->belongsTo('App\Models\Product');
    }

    public function getFullNameAttribute() {
        $res = null;
        $global_values = Value::all();
        if (count($this->values) > 0) {
            $res = '';
            $vals = array_values($this->values);
            $last = end($vals);
            foreach ($this->values as $variation_value_id) {
                foreach ($global_values as $v) {
                    if ($v->id == $variation_value_id) {
                        $res .= $v->title;
                    }
                }
                if ($last != $variation_value_id) {
                    $res .= ', ';
                }
            }
        }
        return $res;
    }

    public function getPriceWithSaleAttribute() {
        $now = Carbon::now();
        if ($this->sale_start && $this->sale_end && $this->sale_start->lt($now) && $this->sale_end->gt($now) && $this->sale_price) {
            return $this->sale_price;
        }
        return $this->price;
    }
}
