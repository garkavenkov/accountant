<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Carbon\Carbon;
use App\Models\Employee;
use Faker\Generator as Faker;
use App\Models\MarkdownDocument;

$factory->define(MarkdownDocument::class, function (Faker $faker) {
    
    $employee = factory(Employee::class)->create();
        
    $sum = $faker->numberBetween($min=100, $max=300);
    
    return [
        'date'                  =>  Carbon::now()->toDateString(),       
        'debet_id'              =>  $employee->department->id,
        'debet_person_id'       =>  $employee->id,
        'credit_id'             =>  0,
        'credit_person_id'      =>  0,
        'sum1'                  =>  0,
        'sum2'                  =>  $sum,
        'user_id'               =>  1,
    ];
});
