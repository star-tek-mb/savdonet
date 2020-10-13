<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Value extends Model
{
    use HasTranslations;

    protected $fillable = ['option_id', 'title'];
    public $translatable = ['title'];
    public $timestamps = false;

    public function option() {
        return $this->belongsTo('App\Models\Option');
    }
}
