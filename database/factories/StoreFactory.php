<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Store;
use Faker\Generator as Faker;

$factory->define(Store::class, function (Faker $faker) {
    return [
        'name' => 'Main',
        'active' => 1,
        'address' => 'Mevlana Mahallesi, Yıldırım Beyazıt Cd. No:27B D:8, 34515 Esenyurt/İstanbul'
    ];
});
