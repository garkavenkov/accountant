<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenseProfitItem extends Model
{
    protected $fillable = [
        'type_id',
        'owner_id',
        'name'        
    ];

    
}
