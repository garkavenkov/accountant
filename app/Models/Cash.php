<?php

namespace App\Models;

use App\Models\Branch;
use Illuminate\Database\Eloquent\Model;

class Cash extends Model
{
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
