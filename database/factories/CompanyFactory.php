<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Company;
use Faker\Generator as Faker;

$factory->define(Company::class, function (Faker $faker) {
    return [
        'company_name' => 'Snooker',
        'service_charge_value' => 0,
        'vat_charge_value' => 0,
        'address' => 'Istanbul',
        'phone' => '00905526996353',
        'country' => 'Turkey',
        'message' => 'Best snooker club in Istanbul.',
        'currency' => 'TRY'
    ];
});
