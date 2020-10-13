<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['delivery_price', 'name', 'email', 'phone', 'region_city', 'address', 'comment', 'status'];

    public function products() {
        return $this->hasMany('App\Models\OrderProduct');
    }
}
