<?php

namespace App\Models;

use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasTranslations;

    protected $fillable = ['category_id', 'title', 'description', 'options', 'supplier_id', 'views'];
    public $translatable = ['title', 'description'];
    protected $casts = ['options' => 'array', 'media' => 'array'];
    protected $with = ['category'];

    public function category() {
        return $this->belongsTo('App\Models\Category');
    }

    public function variations() {
        return $this->hasMany('App\Models\ProductVariation');
    }

    public function supplier() {
        return $this->belongsTo('App\Models\Supplier');
    }

}