<?php

namespace App\Http\Controllers\API;

use App\Models\Shift;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\Shift\ShiftEmployeesResource;

class ShiftEmployeeController extends Controller
{
    public function list($department_id, $date)
    {
        // $employees = [];

        // $sql  = "select id, employee_full_name ";
        // $sql .= "from v_employees where id in (";
        // $sql .= "select employee_id from shift_employees where shift_id = (";
        // $sql .= "select id from shifts where department_id = ? ";
        // $sql .= "and `start` <= ? and `end` >= ?))";

        $shift = Shift::where('date_begin', '<=', $date)
                        ->where('date_end', '>=', $date)
                        ->where('department_id', $department_id)
                        ->first();
        try {
            $employees = $shift->employees;
        } catch (\Throwable $th) {
            $employees = [];
        }
        
        // dd($employees);
        // dd($shift->employees);
        // $employees = \DB::select($sql, [
        //     $department_id,
        //     $date,
        //     $date
        // ]);
        return ShiftEmployeesResource::collection($employees);
    }
}
