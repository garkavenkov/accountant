<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Carbon\Carbon;
use App\Models\Employee;
use App\Models\DocumentType;
use Faker\Generator as Faker;
use App\Models\WritedownDocument;

$factory->define(WritedownDocument::class, function (Faker $faker) {
    
    $document_type = factory(DocumentType::class)->create();

    $employee = factory(Employee::class)->create();
        
    $sum = $faker->numberBetween($min=100, $max=300);
    
    return [
        'date'                  =>  Carbon::now()->toDateString(),       
        'document_type_id'      =>  $document_type->id,
        'debet_id'              =>  $employee->department->id,
        'debet_person_id'       =>  $employee->id,
        'credit_id'             =>  0,
        'credit_person_id'      =>  0,
        'sum1'                  =>  0,
        'sum2'                  =>  $sum,
        'user_id'               =>  1,
    ];
});
