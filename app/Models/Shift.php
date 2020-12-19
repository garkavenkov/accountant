<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Shift;
use App\Models\Branch;
use App\Models\Employee;
use App\Models\Department;
use App\Models\ShiftEmployee;
use App\Traits\Models\PathTrait;
use Illuminate\Database\Eloquent\Model;
use App\Exceptions\API\ShiftDateRangeIntersectFound;

class Shift extends Model
{

    use PathTrait;
    
    private $api_path = "/api/shifts";

    protected $fillable = [
        'department_id',
        'date_begin',
        'date_end'
    ];

    protected static function boot()
    {
        parent::boot();

        // static::addGlobalScope(new IncomeDocumentScope);

        static::saving(function ($model) {                        
            // throw new \Exception('Date diapazon');
            // return response()->json(['message' => 'WTF!!!'], 422);
            // dd($model->department_id);

            $shifts = Shift::where('department_id', $model->department_id)
                            ->where('date_begin', '<=', $model->date_end)
                            ->where('date_end', '>=', $model->date_begin)
                            ->get()
                            ->count();
            // dd($shifts);
            if ($shifts > 0) {
                throw new ShiftDateRangeIntersectFound('Found ' . $shifts . ' shift(s) in range', 422);
            }
        });
    }



    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function employees()
    {
        return $this->hasManyThrough(Employee::class, ShiftEmployee::class, 'shift_id', 'id', 'id', 'employee_id');
        
    }

    public function employeeSalary($employee_id)
    {        
        $employee = $this->employees()->where('employees.id', $employee_id)->first();
        
        return $employee->tariffRates()->where('date', '<=', $this->date_begin)->first();
    }

    public function salesRevenue()
    {
        $sales = SalesRevenue::where('debet_id', $this->department_id)->whereBetween('date', [$this->date_begin, $this->date_end]);// ->get();
        
        $total = $sales->get()->sum('credit');

        $date_begin = Carbon::createFromFormat('Y-m-d', $this->date_begin);
        $date_end = Carbon::createFromFormat('Y-m-d', $this->date_end);
        $days = $date_begin->diffInDays($date_end);
        
        $avg_daily  =   $total / $days;
        $result['date_begin']           =   $this->date_begin;
        $result['date_end']             =   $this->date_end;        
        $result['total']                =   $total;
        $result['days']                 =   $days;
        $result['avg_daily']            =   $avg_daily;
        $result['daily_sales_revenue']  =   $sales->groupBy('date')->selectRaw('sum(credit) as amount, date')->pluck('amount', 'date');
        
        return $result;
    }
}
