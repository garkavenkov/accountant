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
}
