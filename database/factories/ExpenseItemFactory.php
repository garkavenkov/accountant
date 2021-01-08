<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ExpenseItem;
use Faker\Generator as Faker;
use App\Models\ExpenseProfitItemType;

$factory->define(ExpenseItem::class, function (Faker $faker) {
    return [
        'type_id'   =>  factory(ExpenseProfitItemType::class),
        'owner_id'  =>  0,
        'name'      =>  $faker->sentence(3),
    ];
});
