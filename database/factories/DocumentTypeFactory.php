<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\DocumentType;
use Faker\Generator as Faker;

$factory->define(DocumentType::class, function (Faker $faker) {
    return [
        'code'  =>  $faker->sentence(1),
        'name'  =>  $faker->sentence(2),
    ];
});
