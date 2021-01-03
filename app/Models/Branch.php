<?php

namespace App\Models;

use App\Models\Cash;
use App\Models\Employee;
use App\Models\Department;
use App\Traits\Models\PathTrait;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use PathTrait;

    protected $fillable = [
        'name',
        'address',
        'opened',
        'closed'
    ];

    private $api_path="/api/branches";    

    public function departments()
    {
        return $this->hasMany(Department::class);
    }

    public function employees(){
        return $this->hasManyThrough(Employee::class, Department::class);
    }

    public function cashes()
    {
        return $this->hasMany(Cash::class);
    }
}
