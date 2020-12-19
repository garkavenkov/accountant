<?php

namespace App\Http\Controllers\API;

use App\Models\Shift;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\ShiftEmployee;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\ShiftRequest;
use App\Http\Requests\API\ShiftEmployeeRequest;
use App\Http\Resources\API\Shift\ShiftResource;

class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // if (request()->input('per_page')) {
            // $per_page = request()->input('per_page');
        // } else {
            // $per_page = 10;
        // }

        $shifts = Shift::with('department')->orderBy('date_begin', 'desc')->get();//->paginate($per_page);

        return ShiftResource::collection($shifts);
    }
   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ShiftRequest $request)
    {
        $validated = $request->validated();
        try {
            $shift = Shift::create([
                'department_id'     =>  $validated['department_id'],
                'date_begin'        =>  $validated['date_begin'],
                'date_end'          =>  $validated['date_end'],
            ]);
        } catch (\ShiftDateRangeIntersectFound $e) {
            return response()->json($e->getMessage(), $e->getCode());
        }
        
        
        return response()->json($shift, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $shift = Shift::with('department', 'employees')->findOrFail($id);

        return new ShiftResource($shift);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $shift = Shift::findOrFail($id);

        if ($shift->delete()) {
            return response()->json(['message' => 'Shift has been successfully deleted!'], 200);
        }
    }

    public function addEmployee(ShiftEmployeeRequest  $request)
    {
        $validated = $request->validated();
     
        ShiftEmployee::create($validated);

        return response()->json(['message' => 'Employee has been successfully added into shift'], 201);
    }

    public function removeEmployee($shift_id, $employee_id)
    {
        if (is_null($shift_id)) {
            return response()->json(['message' => 'Не указан идентифекатор смены'], 422);
        }
        
        if (is_null($employee_id)) {
            return response()->json(['message' => 'Не указан идентифекатор сотрудника'], 422);
        }
        
        $shift      =  Shift::findOrFail($shift_id);
        $employee   =  Employee::findOrFail($employee_id);
                
        if (ShiftEmployee::where(['shift_id' => $shift_id, 'employee_id' => $employee_id])->first()->delete()) {
            return response()->json(['message' => 'Сотрудник успешно удален из смены'], 200);
        } else {
            return response()->json(['message' => 'Указанный сотрудник отсутсвует в смене'], 422);
        }
    }
}
