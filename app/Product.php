<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $table = 'products';

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
    public function stores()
    {
        return $this->belongsToMany(Store::class);
    }
    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot('qty', 'rate', 'amount', 'is_game');
    }
}
