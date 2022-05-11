<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'users';

    public function group()
    {
        return $this->belongsTo(Groups::class);
    }
    public function store()
    {
        return $this->belongsTo(Store::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
