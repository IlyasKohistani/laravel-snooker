<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'username' => 'admin',
        'password' =>  bcrypt('password'),
        'email' => 'alyas.kohistani@gmail.com',
        'firstname' => 'Mohammad Ilyas',
        'lastname' => 'Kohistani',
        'phone' => '00905526996353',
        'gender' => 1,
        'store_id' => 1, // password
        'group_id' => 1,
        'remember_token' => Str::random(10),
    ];
});