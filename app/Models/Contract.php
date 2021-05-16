<?php

namespace App\Models;

use App\Models\ContractTurn;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $table = 'contracts';
    
    protected $fillable = [
        'date_begin',
        'date_end',
        'contract_type_id',
        'counterparty_id',
        'currency_id',
        'amount'
    ];

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
    
    public function turns()
    {
        return $this->hasMany(ContractTurn::class, 'contract_id', 'id');
    }
}
