<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Branch;
use App\Models\Department;
use Faker\Generator as Faker;
use App\Models\DepartmentType;

$factory->define(Department::class, function (Faker $faker) {
    $branch = factory(Branch::class)->create();
    return [
        'branch_id'             =>  $branch->id,
        'name'                  =>  $faker->sentence(2),
        'description'           =>  $faker->sentence(6),
        'department_type_id'    =>  factory(DepartmentType::class),
        'flag'                  =>  0,
        'opened'                =>  $faker->dateTimeBetween($startDate = $branch->opened, $endDate='-1 month')
    ];
});
