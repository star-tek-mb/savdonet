<?php

namespace App\Models;

use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasTranslations;

    protected $fillable = ['slug', 'number', 'title', 'description', 'seo', 'status', 'views'];
    public $translatable = ['title', 'description'];
}
