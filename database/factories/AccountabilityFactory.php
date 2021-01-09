<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Carbon\Carbon;
use App\Models\Cash;
use App\Models\Employee;
use App\Models\CashOperation;
use Faker\Generator as Faker;
use App\Models\Accountability;

$factory->define(Accountability::class, function (Faker $faker) {
    
    $sum = $faker->numberBetween($min=1000, $max=10000);
    
    return [
        'operation_id'      =>  factory(CashOperation::class),    
        'date'              =>  Carbon::now()->toDateString(),
        'debet_id'          =>  factory(Cash::class),
        'credit_id'         =>  factory(Employee::class),        
        'purpose'           =>  $faker->sentence(4),
        'debet'             =>  $sum,        
        'credit'            =>  0,
        'status'            =>  0,
    ];
});
