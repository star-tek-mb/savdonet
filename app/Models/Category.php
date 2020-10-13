<?php

namespace App\Models;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasTranslations;

    protected $fillable = ['parent_id', 'title', 'photo_url'];
    public $translatable = ['title'];
    public $timestamps = false;

    public function parent() {
        return $this->belongsTo('App\Models\Category', 'parent_id')->with('parent');
    }

    public function children() {
        return $this->hasMany('App\Models\Category', 'parent_id');
    }

    public function products() {
        return $this->hasMany('App\Models\Product', 'category_id');
    }

    private function collect(&$collection, $category) {
        $collection = $collection->concat($category->products->load('variations'));
        foreach ($category->children as $subcategory) {
            $this->collect($collection, $subcategory);
        }
    }

    public function productsAll() {
        $collection = new Collection();
        $this->collect($collection, $this);
        return $collection;
    }
}
