<?php

namespace App\Http\Controllers\API;

use App\Models\Shift;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\Shift\ShiftResource;
use App\Http\Resources\API\Shift\ShiftEmployeesResource;

class ShiftEmployeeController extends Controller
{
    public function employees($department_id, $date)
    {
        $shift = Shift::where('date_begin', '<=', $date)
                        ->where('date_end', '>=', $date)
                        ->where('department_id', $department_id)
                        ->first();
     
        try {
            $employees = $shift->employees;
        } catch (\Throwable $th) {
            $employees = [];
        }
     
        return ShiftEmployeesResource::collection($employees);
    }

    public function shifts($employee_id, $date = null)
    {
        $employee = Employee::findOrFail($employee_id);

        if ($employee) {
            // return response()->json($employee->shifts()->first());
            return new ShiftResource($employee->shifts()->first());
        } else {
            return response()->json(404);
        }
    }
}
