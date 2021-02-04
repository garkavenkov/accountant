<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\CashOperation;
use Faker\Generator as Faker;
use App\Models\CashOperationType;

$factory->define(CashOperation::class, function (Faker $faker) {
    return [
        'code'      =>  $faker->sentence(1),
        'name'      =>  $faker->sentence(2),
        'type_id'   =>  factory(CashOperationType::class),
    ];
});
