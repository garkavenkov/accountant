<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    public function unpaid()
    {        
        return $this->hasMany(IncomeDocument::class, 'debet_id', 'id')->where('status', 0)->orderBy('date');
    }
}
