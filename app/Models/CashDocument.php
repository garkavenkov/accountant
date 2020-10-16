<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashDocument extends Model
{
    protected $fillable = [
        'date',
        'operation_id',
        'number',
        'debit_id',        
        'credit_id',
        'debet',
        'credit',
        'status',
        'user_id'
    ]; 
}
