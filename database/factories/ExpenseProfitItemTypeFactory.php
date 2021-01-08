<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ExpenseProfitItemType;
use Faker\Generator as Faker;

$factory->define(ExpenseProfitItemType::class, function (Faker $faker) {
    return [
        'code'  =>  $faker->sentence(1),
        'name'  =>  $faker->sentence(1),
    ];
});
