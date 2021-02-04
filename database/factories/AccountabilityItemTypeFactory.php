<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\AccountabilityItemType;
use Faker\Generator as Faker;

$factory->define(AccountabilityItemType::class, function (Faker $faker) {
    return [
        'code'      =>  $faker->sentence(1),
        'name'      =>  $faker->sentence(2),
    ];
});
