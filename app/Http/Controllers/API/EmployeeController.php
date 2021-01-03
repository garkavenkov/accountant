<?php

namespace App\Http\Controllers\API;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\Employee\EmployeeResource;
use App\Http\Resources\API\Employee\EmployeeResourceCollection;
use App\Http\Resources\API\Employee\EmployeeTariffRatesResource;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::with('position', 'department.branch')->get();//->paginate(10);
        
        return new EmployeeResourceCollection($employees);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $employee = Employee::create($request->all());

        return new EmployeeResource($employee);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $employee = Employee::with('department', 'position','tariffRates')->findOrFail($id);
        $employee = Employee::findOrFail($id);
        // $employee = Employee::findOrFail($id);
        // return response()->json($employee);
        return new EmployeeResource($employee);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Undocumented function
     *
     * @param int $id
     * @param date $date
     * @return void
     */
    public function currentSalary($id, $date = null)
    {
        $employee = Employee::findOrFail($id);

        $salary = $employee->salary($date);
        if ($salary) {
            // return new EmployeeSalaryResource($salary);
            return new EmployeeTariffRatesResource($salary);
        } else {
            return response()->json(['message' => 'Salary not found', 404]);
        }
    }
}
