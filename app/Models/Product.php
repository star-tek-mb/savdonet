<?php

namespace App\Models;

use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Product extends Model
{
    use HasTranslations;

    protected $fillable = ['category_id', 'title', 'description', 'options', 'supplier_id', 'seo', 'status', 'views'];
    public $translatable = ['title', 'description'];
    protected $casts = ['options' => 'array', 'media' => 'array'];
    protected $with = ['category', 'variations'];

    public function category() {
        return $this->belongsTo('App\Models\Category');
    }

    public function variations() {
        return $this->hasMany('App\Models\ProductVariation');
    }

    public function supplier() {
        return $this->belongsTo('App\Models\Supplier');
    }

    public function getPriceAttribute() {
        $min = 999999999;
        $max = 0;
        foreach ($this->variations as $variation) {
            if ($variation->price < $min) {
                $min = $variation->price;
            }
            if ($variation->price > $max) {
                $max = $variation->price;
            }
        }
        return array($min, $max);
    }

    public function getSalePriceAttribute() {
        $min = 999999999;
        $max = 0;
        $now = Carbon::now();
        foreach ($this->variations as $variation) {
            if (!$variation->sale_start || !$variation->sale_end || !$variation->sale_start->lt($now)
                        || !$variation->sale_end->gt($now) || !$variation->sale_price) {
                return null;
            }
            if ($variation->price < $min) {
                $min = $variation->sale_price;
            }
            if ($variation->price > $max) {
                $max = $variation->sale_price;
            }
        }
        return array($min, $max);
    }
}