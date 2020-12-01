<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Carbon\Carbon;
use App\Models\Rest;
use App\Models\RestType;
use Faker\Generator as Faker;

$factory->define(Rest::class, function (Faker $faker) {
    return [
        'date'          =>  Carbon::now()->toDateString(),
        'rest_type_id'  =>  factory(RestType::class),
        'owner_id'      =>  1,
        'rest'          =>  $faker->numberBetween($min=10000, $max=20000)
    ];
});
