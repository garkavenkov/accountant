<?php

namespace App\Models;

use App\Models\Branch;
use App\Models\Position;
use App\Models\Department;
use Illuminate\Support\Str;
use App\Traits\Models\PathTrait;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use PathTrait;
    
    private $api_path = "/api/employees";

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
   
    public function getFullNameAttribute()
    {        
        return  $this->surname . ' ' . 
                Str::ucfirst(Str::substr($this->name, 0, 1)) . '.' . 
                Str::ucfirst(Str::substr($this->patronymic, 0, 1)) . '.';
    }

}
