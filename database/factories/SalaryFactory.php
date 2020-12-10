<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Carbon\Carbon;
use App\Models\Cash;
use App\Models\Salary;
use App\Models\Employee;
use App\Models\CashOperation;
use Faker\Generator as Faker;

$factory->define(Salary::class, function (Faker $faker) {
    
    return [
        'date'              =>  Carbon::now()->toDateString(),
        'operation_id'      =>  factory(CashOperation::class),
        // 'number'            =>  1
        'debet_id'          =>  factory(Cash::class),
        'credit_id'         =>  factory(Employee::class),
        'debet'             =>  $faker->numberBetween($min=1000, $max=10000),
        'purpose'           =>  $faker->sentence(4),
        'status'            =>  0,
        // 'user_id'
    ];
});
