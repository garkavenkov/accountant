<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Carbon\Carbon;
use App\Models\Cash;
use App\Models\Department;
use App\Models\CashDocument;
use App\Models\CashOperation;
use Faker\Generator as Faker;

$factory->define(CashDocument::class, function (Faker $faker) {
    
    return [
        'operation_id'      =>  factory(CashOperation::class),
        'date'              =>  Carbon::now(),       
        'number'            =>  1,
        'debet_id'          =>  factory(Department::class),
        'credit_id'         =>  factory(Cash::class),
        'purpose'           =>  $faker->sentance(3),
        'debet'             =>  0,
        'credit'            =>  $faker->numberBetween($min=1000, $max=10000),
        'status'            =>  0,
        'user_id'           =>  1,
    ];
});
