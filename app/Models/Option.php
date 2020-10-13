<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Option extends Model
{
    use HasTranslations;

    protected $fillable = ['title'];
    public $translatable = ['title'];
    public $timestamps = false;

    public function values() {
        return $this->hasMany('App\Models\Value');
    }
}
