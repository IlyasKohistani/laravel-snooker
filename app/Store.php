<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    //
    protected $table = 'stores';
    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function Products()
    {
        return $this->belongsToMany(Product::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function tables()
    {
        return $this->hasMany(Table::class);
    }
}
