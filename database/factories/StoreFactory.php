<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Store;
use Faker\Generator as Faker;

$factory->define(Store::class, function (Faker $faker) {
    return [
        'name' => 'Main',
        'active' => 1,
        'address' => 'Esenyurt/İstanbul'
    ];
});
