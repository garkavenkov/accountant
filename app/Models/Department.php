<?php

namespace App\Models;

use App\Models\Shift;
use App\Models\DepartmentType;
use App\Traits\Models\PathTrait;
use Illuminate\Database\Eloquent\Model;

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

    public function scopeGoods($query)
    {
        return $query->whereRaw('flag & 1 = 1');
    }

    public function shifts()
    {
        return $this->hasMany(Shift::class);
    }

    public function type()
    {
        return $this->belongsTo(DepartmentType::class, 'department_type_id', 'id');
    }
}
