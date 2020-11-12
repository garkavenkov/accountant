<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Payment;
use Faker\Generator as Faker;
use App\Models\IncomeDocument;
use App\Models\LinkedDocument;
use App\Models\LinkedDocumentType;

$factory->define(LinkedDocument::class, function (Faker $faker) {
    return [
        'type_id'               =>  factory(LinkedDocumentType::class),
        'cash_document_id'      =>  factory(Payment::class),
        'owner_id'              =>  factory(IncomeDocument::class),
    ];
});
