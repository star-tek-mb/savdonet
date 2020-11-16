<?php

namespace App\Models;

use App\Models\Option;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Soundasleep\Html2Text;

class Product extends Model
{
    use HasTranslations;

    protected $fillable = ['category_id', 'title', 'description', 'options', 'supplier_id', 'seo', 'status', 'views'];
    public $translatable = ['title', 'description'];
    protected $casts = ['options' => 'array', 'media' => 'array'];
    protected $with = ['category', 'variations'];
    protected $appends = ['text_descriptions'];

    public function category() {
        return $this->belongsTo('App\Models\Category');
    }

    public function variations() {
        return $this->hasMany('App\Models\ProductVariation');
    }

    public function supplier() {
        return $this->belongsTo('App\Models\Supplier');
    }

    public function getFullNameAttribute() {
        $res = null;
        $global_options = Option::all();
        if (count($this->options) > 0) {
            $res = '';
            $vals = array_values($this->options);
            $last = end($vals);
            foreach ($this->options as $option_id) {
                foreach ($global_options as $o) {
                    if ($o->id == $option_id) {
                        $res .= $o->title;
                    }
                }
                if ($last != $option_id) {
                    $res .= ', ';
                }
            }
        }
        return $res;
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
        $price = 0;
        foreach ($this->variations as $variation) {
            $price = $variation->sale_price;
            if (!$variation->sale_start || !$variation->sale_end || !$variation->sale_start->lt($now)
                        || !$variation->sale_end->gt($now) || !$variation->sale_price) {
                $price = $variation->price;
            }
            if ($price < $min) {
                $min = $price;
            }
            if ($price > $max) {
                $max = $price;
            }
        }
        return array($min, $max);
    }

    public function getTextDescriptionsAttribute() {
        $options = array(
            'ignore_errors' => true,
            'drop_links' => true
        );
        $result = [];
        $description_translations = $this->getTranslations('description');
        foreach ($description_translations as $locale => $translation) {
            $result[$locale] = Str::limit(Html2Text::convert($translation, $options), 100, '...');
        }
        return $result;
    }

    public function getTextDescriptionAttribute() {
        $options = array(
            'ignore_errors' => true,
            'drop_links' => true
        );
        return Str::limit(Html2Text::convert($this->description, $options), 100, '...');
    }
}