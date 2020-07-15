<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Measure;
use App\Models\DocumentItem;
use Faker\Generator as Faker;
use App\Models\IncomeDocument;

$factory->define(DocumentItem::class, function (Faker $faker) {

    $document_id    =   factory(IncomeDocument::class)->create()->id;
    $qty            =   $faker->randomDigitNot(0);
    $price          =   $faker->numberBetween($min = 10, $max = 500);
    
    return [        
        'document_id'       =>  $document_id,
        'number'            =>  1,
        'name'              =>  $faker->sentence($nbWords = 4, $variableNbWords = true),
        'measure_id'        =>  factory(Measure::class),
        'quantity'          =>  $qty,
        'price'             =>  $price,
        'price2'            =>  $price * 1.2
    ];
});

