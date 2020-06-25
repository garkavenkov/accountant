<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Supplier;
use Faker\Generator as Faker;

$factory->define(Supplier::class, function (Faker $faker) {
    $name = $faker->company;
    
    return [
        'name'          =>  $name,
        'full_name'     =>  $name,
        'description'   =>  $faker->catchPhrase
    ];
});
