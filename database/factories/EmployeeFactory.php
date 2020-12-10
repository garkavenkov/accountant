<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Employee;
use App\Models\Position;
use App\Models\Department;
use App\Models\TariffRate;
use Faker\Generator as Faker;

$factory->define(Employee::class, function (Faker $faker) {
    return [
        'name'          =>  $faker->firstNameMale,
        'patronymic'    =>  $faker->middleNameMale,
        'surname'       =>  $faker->lastName,
        'birthdate'     =>  $faker->dateTimeBetween($startDate = '-50 years', $endDate = '-20 years', $timezome='Europe/Moscow')->format("Y-m-d"),
        'address'       =>  $faker->address,  
        'department_id' =>  factory(Department::class),
        'position_id'   =>  factory(Position::class),
        'hired'         =>  $faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now', $timezome='Europe/Moscow')->format("Y-m-d"),
    ];
});

$factory->state(TariffRate::class, 'salary', [])
        ->afterCreatingState(Employee::class, 'salary', function($employee, Faker $faker) {
            factory(TariffRate::class, 2)->create(['employee_id' => $employee->id]);
        });