<?php

namespace App\Models;

use App\Models\Employee;
use App\Traits\Models\PathTrait;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use PathTrait;

    private $api_path = "/api/positions";

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
    
}
