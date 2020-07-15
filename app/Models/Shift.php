<?php

namespace App\Models;

use App\Models\Branch;
use App\Models\Employee;
use App\Models\Department;
use App\Models\ShiftEmployee;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function employees()
    {
        return $this->hasManyThrough(Employee::class, ShiftEmployee::class, 'shift_id', 'id');
        
    }
}
