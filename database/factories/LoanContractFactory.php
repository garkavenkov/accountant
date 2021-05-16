<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Carbon\Carbon;
use App\Models\Cash;
use App\Models\Currency;
use App\Models\ContractType;
use App\Models\Counterparty;
use App\Models\LoanContract;
use Faker\Generator as Faker;

$factory->define(LoanContract::class, function (Faker $faker) {
    return [
        'date_begin'        =>  Carbon::now()->toDatestring(),
        'cash_id'           =>  factory(Cash::class),
        'contract_type_id'  =>  factory(ContractType::class),
        'counterparty_id'   =>  factory(Counterparty::class),
        'currency_id'       =>  factory(Currency::class),
        'amount'            =>  $faker->numberBetween($min=1000, $max=10000),
        'amount2'           =>  0
    ];
});
