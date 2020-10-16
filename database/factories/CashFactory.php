<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Cash;
use App\Models\Branch;
use Faker\Generator as Faker;

$factory->define(Cash::class, function (Faker $faker) {
    return [
        'branch_id'     =>  factory(Branch::class),
        'name'          =>  $faker->sentence(2)
    ];
});
