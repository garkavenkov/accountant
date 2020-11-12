<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Carbon\Carbon;
use App\Models\Cash;
use App\Models\Payment;
use App\Models\Supplier;
use App\Models\CashOperation;
use Faker\Generator as Faker;

$factory->define(Payment::class, function (Faker $faker) {
    
    $sum = $faker->numberBetween($min=1000, $max=10000);
    // dd(CashOperation::all());
    // $operation_id = CashOperation::where('code', 'sales_revenue')->first()->id;

    return [
        'operation_id'      =>  factory(CashOperation::class),
        // 'operation_id'      =>  1,
        'date'              =>  Carbon::now()->toDateString(),
        'debet_id'          =>  factory(Cash::class),
        'credit_id'         =>  factory(Supplier::class),        
        'purpose'           =>  $faker->sentence(4),
        'debet'             =>  $sum,        
        'credit'            =>  0,
        'status'            =>  0,
        // 'user_id'           =>  \Auth::id()
    ];

});
