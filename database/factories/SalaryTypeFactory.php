<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\SalaryType;
use Faker\Generator as Faker;

$factory->define(SalaryType::class, function (Faker $faker) {
    return [
        'code'          =>  $faker->sentence(1),
        'name'          =>  $faker->sentence(2),
        'description'   =>  $faker->sentence(6),
    ];
});
