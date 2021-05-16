<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ContractType;
use Faker\Generator as Faker;

$factory->define(ContractType::class, function (Faker $faker) {
    return [
        'code'  =>  $faker->sentence($nbWords = 1, $variableNbWords = true),
        'name'  =>  $faker->sentence($nbWords = 2, $variableNbWords = true),
    ];
});
