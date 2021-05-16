<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Currency;
use Faker\Generator as Faker;

$factory->define(Currency::class, function (Faker $faker) {
    return [
        'code'      =>  $faker->currencyCode,
        'number'    =>  $faker->randomNumber($nbDigits = 3, $strict = false),
        'name'      =>  $faker->sentence($nbWords = 2, $variableNbWords = true),
    ];
});
