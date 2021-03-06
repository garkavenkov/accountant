<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\CashOperationType;
use Faker\Generator as Faker;

$factory->define(CashOperationType::class, function (Faker $faker) {
    return [
        'code'      =>  $faker->sentence(1),
        'name'      =>  $faker->sentence(2),
    ];
});
