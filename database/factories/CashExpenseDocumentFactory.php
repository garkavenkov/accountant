<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Carbon\Carbon;
use App\Models\Cash;
use App\Models\ExpenseItem;
use App\Models\CashOperation;
use Faker\Generator as Faker;
use App\Models\CashExpenseDocument;

$factory->define(CashExpenseDocument::class, function (Faker $faker) {
    
    $sum = $faker->numberBetween($min=1000, $max=10000);
    
    return [
        'operation_id'      =>  factory(CashOperation::class),
        'date'              =>  Carbon::now()->toDateString(),
        'debet_id'          =>  factory(Cash::class),
        'credit_id'         =>  factory(ExpenseItem::class),        
        'purpose'           =>  $faker->sentence(4),
        'debet'             =>  $sum,        
        'credit'            =>  0,
        'status'            =>  0,
    ];
});
