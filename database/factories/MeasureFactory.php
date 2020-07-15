<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Measure;
use Faker\Generator as Faker;

$factory->define(Measure::class, function (Faker $faker) {
    $measure = $faker->sentence(1);
    return [
        'name'          =>  $measure,
        'full_name'     =>  $measure,
    ];
});
