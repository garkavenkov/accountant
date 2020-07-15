<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Shift;
use App\Models\Employee;
use App\Models\ShiftEmployee;
use Faker\Generator as Faker;

$factory->define(ShiftEmployee::class, function (Faker $faker) {
    return [
        'shift_id'      =>  factory(Shift::class),
        'employee_id'   =>  factory(Employee::class)
    ];
});
