<?php

namespace App\Models;

use App\Models\SalaryType;
use Illuminate\Database\Eloquent\Model;

class TariffRate extends Model
{
    protected $fillable = [
        'employee_id',
        'salary_type_id',
        'date',
        'amount'
    ];

    public function type()
    {
        return $this->belongsTo(SalaryType::class, 'salary_type_id');
    }

}
