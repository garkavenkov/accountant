<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Models\PathTrait;

class Department extends Model
{
    use PathTrait;

    private $api_path="/api/departments";

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
    
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
