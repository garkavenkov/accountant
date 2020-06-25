<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Employee;
use App\Models\Position;
use App\Models\Department;
use Faker\Generator as Faker;

$factory->define(Employee::class, function (Faker $faker) {
    return [
        'name'          =>  $faker->firstNameMale,
        'patronymic'    =>  $faker->middleNameMale,
        'surname'       =>  $faker->lastName,
        'birthdate'     =>  $faker->dateTimeBetween($startDate = '-50 years', $endDate = '-20 years'),
        'address'       =>  $faker->address,  
        'department_id' =>  factory(Department::class),
        'position_id'   =>  factory(Position::class),
        'hired'         =>  $faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now'),
    ];
});
