<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Groups;
use Faker\Generator as Faker;

$factory->define(Groups::class, function (Faker $faker) {
    $data = 'a:33:{i:0;s:10:"createUser";i:1;s:10:"updateUser";i:2;s:8:"viewUser";i:3;s:10:"deleteUser";i:4;s:11:"createGroup";i:5;s:11:"updateGroup";i:6;s:9:"viewGroup";i:7;s:11:"deleteGroup";i:8;s:11:"createStore";i:9;s:11:"updateStore";i:10;s:9:"viewStore";i:11;s:11:"deleteStore";i:12;s:11:"createTable";i:13;s:11:"updateTable";i:14;s:9:"viewTable";i:15;s:11:"deleteTable";i:16;s:14:"createCategory";i:17;s:14:"updateCategory";i:18;s:12:"viewCategory";i:19;s:14:"deleteCategory";i:20;s:13:"createProduct";i:21;s:13:"updateProduct";i:22;s:11:"viewProduct";i:23;s:13:"deleteProduct";i:24;s:11:"createOrder";i:25;s:11:"updateOrder";i:26;s:9:"viewOrder";i:27;s:11:"deleteOrder";i:28;s:10:"viewReport";i:29;s:13:"updateCompany";i:30;s:11:"viewProfile";i:31;s:13:"updateSetting";i:32;s:13:"updatePayment";}';
    $serialized_data = unserialize($data);
    return [
        'permission' => serialize($serialized_data),
        'group_name' => 'Super Administrator'
    ];
});
