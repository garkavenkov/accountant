<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Models\Accountability;
use App\Models\IncomeDocument;
use App\Models\AccountabilityItem;
use App\Models\AccountabilityItemType;

$factory->define(AccountabilityItem::class, function (Faker $faker) {

    $doc = factory(IncomeDocument::class)->create();

    return [
        'cash_document_id'  =>  factory(Accountability::class),
        'type_id'           =>  factory(AccountabilityItemType::class),
        'owner_id'          =>  $doc->id,
        'amount'            =>  $doc->sum1
    ];
});
