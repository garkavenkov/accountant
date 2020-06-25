<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Branch;
use App\Models\Department;
use Faker\Generator as Faker;

$factory->define(Department::class, function (Faker $faker) {
    $branch = factory(Branch::class)->create();
    return [
        'branch_id'     =>  $branch->id,
        'name'          =>  $faker->sentence(2),
        'description'   =>  $faker->sentence(6),
        'opened'        =>  $faker->dateTimeBetween($startDate = $branch->opened, $endDate='-1 month')
        // 'opened'        =>  $faker->dateTimeBetween($startDate = '-3 month', $endDate='-1 month')
    ];
});
