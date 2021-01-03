<?php

namespace App\Http\Controllers\API;

use App\Models\Department;
use App\Models\SalesRevenue;
use Illuminate\Http\Request;
use App\Models\IncomeDocument;
use App\Models\MarkupDocument;
use App\Models\ExpenseDocument;
use App\Models\MarkdownDocument;
use App\Models\TransferDocument;
use App\Models\WritedownDocument;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\DepartmentRequest;
use App\Http\Resources\API\Department\DepartmentResource;
use App\Http\Resources\API\Department\DepartmentResourceCollection;
use App\Http\Resources\API\DepartmentTurns\DepartmentTurnsResource;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = Department::with('type')->get();

        return new DepartmentResourceCollection($departments);
        // return response()->json($departments);
    }
   
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DepartmentRequest $request)
    {
        $department = Department::create($request->validated());

        return new DepartmentResource($department);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $department = Department::with('employees.position')->findOrFail($id);
        
        return new DepartmentResource($department);
        // return response()->json($department);
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

    public function turns(Request $request)
    {
        // dd(request()->input('id'));
        $parameters = request()->input();

        if ( isset($parameters['id']) ) {
            $id = $parameters['id'];
        } else {
            $id = 0;  
        }
        
        if ( isset($parameters['date_begin']) ) {
            $date_begin = $parameters['date_begin'];
        } else {
            $date_begin = Carbon::now()->toDateString();
        }

        if ( isset($parameters['date_end']) ) {
            $date_end = $parameters['date_end'];
        } else {
            $date_end = $date_begin;
        }

        // dd($id, $date_begin, $date_end);

        if ($id == 0) {
            $departments = Department::goods()->get();    
        } else {
            $ids = explode(',', $id);
            $departments = Department::goods()->whereIn('id', $ids)->get();
            // $departments[0]->incomeRest($date_begin);
        }                    

        $turns = [];
        
        // $date = $date_begin;

        foreach ($departments as $department) {
        
            $income_rest            = $department->incomeRest($date_begin);
            $income_sum             = IncomeDocument::where('credit_id', $department->id)->whereBetween('date', [$date_begin, $date_end])->get()->sum('sum2');
            $transfer_income_sum    = TransferDocument::where('credit_id', $department->id)->whereBetween('date', [$date_begin, $date_end])->get()->sum('sum2');
            $markup_sum             = MarkupDocument::where('credit_id', $department->id)->whereBetween('date', [$date_begin, $date_end])->get()->sum('sum2');

            $total_income           = $income_sum + $transfer_income_sum + $markup_sum;

            $sales_revenue_sum      = SalesRevenue::where('debet_id', $department->id)->whereBetween('date', [$date_begin, $date_end])->get()->sum('credit');
            $transfer_outcome_sum   = TransferDocument::where('debet_id', $department->id)->whereBetween('date', [$date_begin, $date_end])->get()->sum('sum1');
            $markdown_sum           = MarkdownDocument::where('debet_id', $department->id)->whereBetween('date', [$date_begin, $date_end])->get()->sum('sum2');
            $writedown_sum          = WritedownDocument::where('debet_id', $department->id)->whereBetween('date', [$date_begin, $date_end])->get()->sum('sum2');
            $expense_sum            = ExpenseDocument::where('debet_id', $department->id)->whereBetween('date', [$date_begin, $date_end])->get()->sum('sum2');  
        
            $total_outcome          = $sales_revenue_sum + $transfer_outcome_sum + $markdown_sum + $writedown_sum + $expense_sum;

            $turns[$department->id]['departmentId']          =   $department->id;
            $turns[$department->id]['department']            =   $department->name;
            $turns[$department->id]['date']                  =   $date_begin;
            $turns[$department->id]['incomeRest']            =   $income_rest;

            $turns[$department->id]['credit']['total']       =   $total_income;
            $turns[$department->id]['credit']['income']      =   $income_sum;
            $turns[$department->id]['credit']['transfer']    =   $transfer_income_sum;
            $turns[$department->id]['credit']['markup']      =   $markup_sum;

            $turns[$department->id]['debet']['total']        =   $total_outcome;
            $turns[$department->id]['debet']['sales']        =   $sales_revenue_sum;
            $turns[$department->id]['debet']['transfer']     =   $transfer_outcome_sum;
            $turns[$department->id]['debet']['markdown']     =   $markdown_sum;
            $turns[$department->id]['debet']['writedown']    =   $writedown_sum;
            $turns[$department->id]['debet']['expense']      =   $expense_sum;

            $turns[$department->id]['outcomeRest']           =   $income_rest + $total_income - $total_outcome;

        }       
       
        
        return DepartmentTurnsResource::collection($turns);
    }
}
