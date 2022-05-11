<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $dates = ['end_time'];

    public function Products()
    {
        return $this->belongsToMany(Product::class)->withPivot('qty', 'rate', 'amount', 'is_game');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function store()
    {
        return $this->belongsTo(Store::class);
    }
    public function table()
    {
        return $this->belongsTo(Table::class);
    }
}
