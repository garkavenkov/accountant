<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Shift;
use App\Models\Branch;
use App\Models\Position;
use App\Models\Department;
use Illuminate\Support\Str;
use App\Models\ShiftEmployee;
use App\Traits\Models\PathTrait;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use PathTrait;
    
    private $api_path = "/api/employees";

    protected $appends = ['full_name'];

    protected $fillable = [
        'surname',
        'name',
        'patronymic',
        'address',
        'position_id',
        'department_id',
        'birthdate',
        'hired',
        'fired'
    ];

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

    public function tariffRates()
    {
        return $this->hasMany(TariffRate::class)->orderBy('date', 'desc');
    }

    public function salary($date = null)
    {
        if (is_null($date)) {
            $date = Carbon::now()->format('Y-m-d');
        }

        return $this->tariffRates()->where('date',  '<=', $date)->first();
    }

    public function shifts()
    {
        return $this->hasManyThrough(Shift::class, ShiftEmployee::class, 'employee_id', 'id', 'id', 'shift_id')->orderBy('date_end', 'desc');
    }

    public function currentShift($date = null)
    {
        if (is_null($date)) {
            $date = Carbon::now()->format('Y-m-d');
        }

        return $this->shifts()->where('date_begin', '<=', $date)->where('date_end', '>=', $date)->first();
    }
}

