<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractTurn extends Model
{
    protected $fillable = [
        'contract_id',
        'date',
        'amount'
    ];
}
