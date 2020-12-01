<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Carbon\Carbon;
use App\Models\Employee;
use App\Models\Supplier;
use App\Models\DocumentItem;
use App\Models\DocumentType;
use Faker\Generator as Faker;
use App\Models\IncomeDocument;


$factory->define(IncomeDocument::class, function (Faker $faker) {

    $employee = factory(Employee::class)->create();
    
    $sum = $faker->numberBetween($min=1000, $max=10000);

    return [
        'date'                  =>  Carbon::now()->toDatestring(),   
        'document_type_id'      =>  factory(DocumentType::class),
        'debet_id'              =>  factory(Supplier::class),        
        'credit_id'             =>  $employee->department->id,
        'credit_person_id'      =>  $employee->id,
        'sum1'                  =>  $sum,
        'sum2'                  =>  $sum * 1.2,
        'user_id'               =>  1,
    ];
});

$factory->state(IncomeDocument::class, 'items', [])
        ->afterCreatingState(IncomeDocument::class, 'items', function($document, Faker $faker) {
            factory(DocumentItem::class, 5)->create(['document_id' => $document->id]);
        });