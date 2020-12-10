<?php

namespace App\Http\Controllers\API;

use App\Models\Shift;
use App\Models\Salary;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Services\DocumentService;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\SalaryRequest;
use App\Http\Resources\API\Salary\SalaryResource;
use App\Http\Resources\API\Salary\SalaryResourceCollection;

class SalaryController extends Controller
{

    protected $documents;

    public function __construct(DocumentService $service)
    {
        $this->documents = $service;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parameters = request()->input();        
        
        $parameters['with'] = 'cash,employee';

        if (request()->input('per_page')) {
            $per_page = request()->input('per_page');
        } else {
            $per_page = 10;
        }
        
        $data = $this->documents->get(Salary::class, $parameters);


        // $documents = Salary::all();
        
        return new SalaryResourceCollection($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SalaryRequest $request)
    {
        $validated = $request->validated();
       
        $document = Salary::create([
            'date'              =>  $validated['date'],
            'debet_id'          =>  $validated['debet_id'],
            'credit_id'         =>  $validated['credit_id'],            
            'debet'             =>  $validated['debet'],
            'purpose'           =>  $validated['purpose'],
            'status'            =>  0,
        ]);    

        return response()->json($document, 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $document = Salary::findOrFail($id);

        return new SalaryResource($document);
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

    public function shiftsSalesRevenue($shift_id, $employee_id)
    {
        // dd("ShiftId: {$shift_id}, EmployeeId: {$employee_id}");
        $shift = Shift::findOrFail($shift_id);
        // dd($shift->employees);
        $employee = Employee::findOrFail($employee_id);
        
        $employeeSalary = $shift->employeeSalary($employee_id);
        
        $dailySalesRevenue = $shift->salesRevenue()['daily_sales_revenue']->toArray();
        // dd($dailySalesRevenue);
        $salary = 0;
        foreach ($dailySalesRevenue as $date => $sales) {            
            $dailySalary[$date]  = $sales /100 * $employeeSalary['amount'];
            $salary += $sales /100 * $employeeSalary['amount'];
        }
        // $dailySalary = array_map(function($date, $sales) {
        // dd($dailySalary);
        // }, $dailySalesRevenue);
        
        return response()->json(['salary' => $salary]);
    }
}
