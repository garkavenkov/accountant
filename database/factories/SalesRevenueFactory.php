<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Carbon\Carbon;
use App\Models\Cash;
use App\Models\Department;
use App\Models\SalesRevenue;
use App\Models\CashOperation;
use Faker\Generator as Faker;

$factory->define(SalesRevenue::class, function (Faker $faker) {
    
    $sum = $faker->numberBetween($min=1000, $max=10000);
    // dd(CashOperation::all());
    // $operation_id = CashOperation::where('code', 'sales_revenue')->first()->id;

    return [
        'operation_id'      =>  factory(CashOperation::class),
        // 'operation_id'      =>  1,
        'date'              =>  Carbon::now()->toDateString(),
        'debet_id'          =>  factory(Department::class),
        'credit_id'         =>  factory(Cash::class),
        'debet'             =>  0,
        'credit'            =>  $sum,
        'status'            =>  0,
        // 'user_id'           =>  \Auth::id()
    ];
});
