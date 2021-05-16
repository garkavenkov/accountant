<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Counterparty;
use Faker\Generator as Faker;

$factory->define(Counterparty::class, function (Faker $faker) {
    $name = $faker->name;
    return [
        'name'      =>  $name,
        'full_name' =>  $name
    ];
});
