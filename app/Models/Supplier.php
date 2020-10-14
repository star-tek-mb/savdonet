<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = ['name', 'shop_name', 'address', 'phone'];

    public function products() {
        return $this->hasMany('App\Models\Product');
    }
}
