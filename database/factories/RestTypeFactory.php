<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\RestType;
use Faker\Generator as Faker;

$factory->define(RestType::class, function (Faker $faker) {
    return [
        'code'          =>  $faker->sentence(1),
        'name'          =>  $faker->sentence(1),
        'description'   =>  $faker->sentence(5),
    ];
});
