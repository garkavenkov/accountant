<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShiftEmployee extends Model
{
    protected $fillable = [
        'shift_id',
        'employee_id'
    ];
}
