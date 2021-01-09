<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Carbon\Carbon;
use App\Models\Employee;
use App\Models\Supplier;
use App\Models\DocumentType;
use Faker\Generator as Faker;
use App\Models\ReturnDocument;

$factory->define(ReturnDocument::class, function (Faker $faker) {
    
    $employee = factory(Employee::class)->create();
    
    $sum = $faker->numberBetween($min=1000, $max=10000);

    return [
        'date'                  =>  Carbon::now()->toDatestring(),   
        'document_type_id'      =>  factory(DocumentType::class),
        'debet_id'              =>  $employee->department->id,
        'debet_person_id'       =>  $employee->id,
        'credit_id'             =>  factory(Supplier::class),        
        'sum1'                  =>  $sum * 1.2,
        'sum2'                  =>  $sum,
        'user_id'               =>  1,
    ];
});
