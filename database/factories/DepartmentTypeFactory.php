<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Models\DepartmentType;

$factory->define(DepartmentType::class, function (Faker $faker) {
    return [
        'code'          =>  $faker->sentence(1),
        'name'          =>  $faker->sentence(2),
        'description'   =>  $faker->sentence(6),
    ];
});
