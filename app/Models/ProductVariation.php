<?php

namespace App\Models;

use App\Models\Value;
use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    protected $fillable = ['product_id', 'stock', 'price', 'photo_url', 'values', 'sale_price', 'sale_start', 'sale_end'];
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
}
