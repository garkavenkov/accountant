<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountabilityItem extends Model
{
    protected $fillable = [
        'cash_document_id',
        'type_id',
        'owner_id',
        'amount'
    ];

    public function type()
    {
        return $this->belongsTo(AccountabilityItemType::class, 'type_id', 'id');
    }
}
