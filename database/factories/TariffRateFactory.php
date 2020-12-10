<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Employee;
use App\Models\SalaryType;
use App\Models\TariffRate;
use Faker\Generator as Faker;

$factory->define(TariffRate::class, function (Faker $faker) {
    
    $employee = factory(Employee::class)->create();
    
    return [
        'employee_id'       =>  $employee->id,
        'salary_type_id'    =>  factory(SalaryType::class),
        'date'              =>  $employee->hired,
        'amount'            =>  $faker->randomElement([5000, 8000, 10000, 15000, 30000])
    ];
});
