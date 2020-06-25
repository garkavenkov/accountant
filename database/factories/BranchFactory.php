<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Branch;
use Faker\Generator as Faker;

$factory->define(Branch::class, function (Faker $faker) {
    return [
        'name'      =>  $faker->company,
        'address'   =>  $faker->address,
        'opened'    =>  $faker->dateTimeBetween($startDate = "-1 year", $endDate = "-1 month")
    ];
});
