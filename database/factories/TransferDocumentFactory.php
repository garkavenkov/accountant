<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Carbon\Carbon;
use App\Models\Employee;
use Faker\Generator as Faker;
use App\Models\TransferDocument;

$factory->define(TransferDocument::class, function (Faker $faker) {
    
    $employee_gives = factory(Employee::class)->create();
    $employee_takes = factory(Employee::class)->create();

    $sum = $faker->numberBetween($min=1000, $max=10000);

    return [
        'date'                  =>  Carbon::now()->toDateString(),       
        'debet_id'              =>  $employee_gives->department->id,
        'debet_person_id'       =>  $employee_gives->id,
        'credit_id'             =>  $employee_takes->department->id,
        'credit_person_id'      =>  $employee_takes->id,
        'sum1'                  =>  $sum,
        'sum2'                  =>  $sum,
        'user_id'               =>  1,
    ];
    
});
