<?php

namespace App\Http\Controllers\API;

use App\Models\Department;
use App\Models\SalesRevenue;
use Illuminate\Http\Request;
use App\Models\IncomeDocument;
use App\Models\MarkupDocument;
use App\Models\ReturnDocument;
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
        $parameters = request()->input();
        // dd(request()->input());
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
            // dd($parameters['date_end']);
            $date_end = $parameters['date_end'];
        } else {
            $date_end = $date_begin;
        }

        if (isset($parameters['set_rest'])) {
            
            $set_rest = $parameters['set_rest'];
        } else {
            $set_rest = 0;
        }
        
        // dd($id, $date_begin, $date_end);

        // if ($id == 0) {
        //     $departments = Department::goods()->get();    
        // } else {
        //     $ids = explode(',', $id);
        //     $departments = Department::goods()->whereIn('id', $ids)->get();
        //     // $departments[0]->incomeRest($date_begin);
        // }                    
        $department = Department::goods()->where('id', $id)->first();

        $turns = [];
        
        // $date = $date_begin;
        // dd($department->incomeRest($date_begin));

        // foreach ($departments as $department) {
            // dd($department);
            $income_rest            = $department->incomeRest($date_begin);
            
            $income                 = IncomeDocument::where('credit_id', $department->id)->whereBetween('date', [$date_begin, $date_end])->get();
            $income_sum             = $income->sum('sum2');
            
            $transfer_income        = TransferDocument::where('credit_id', $department->id)->whereBetween('date', [$date_begin, $date_end])->get();
            $transfer_income_sum    = $transfer_income->sum('sum2');
            
            $markup                 = MarkupDocument::where('credit_id', $department->id)->whereBetween('date', [$date_begin, $date_end])->get();
            $markup_sum             = $markup->sum('sum2');

            $total_income           = $income_sum + $transfer_income_sum + $markup_sum;

            $sales_revenue          = SalesRevenue::where('debet_id', $department->id)->whereBetween('date', [$date_begin, $date_end])->get();
            $sales_revenue_sum      = $sales_revenue->sum('credit');
            
            $transfer_outcome       = TransferDocument::with('department_takes')->where('debet_id', $department->id)->whereBetween('date', [$date_begin, $date_end])->get();
            $transfer_outcome_sum   = $transfer_outcome->sum('sum1');

            $markdown               = MarkdownDocument::where('debet_id', $department->id)->whereBetween('date', [$date_begin, $date_end])->get();
            $markdown_sum           = $markdown->sum('sum2');
            
            $writedown              = WritedownDocument::where('debet_id', $department->id)->whereBetween('date', [$date_begin, $date_end])->get();
            $writedown_sum          = $writedown->sum('sum2');
            
            $expense                = ExpenseDocument::where('debet_id', $department->id)->whereBetween('date', [$date_begin, $date_end])->get();  
            $expense_sum            = $expense->sum('sum2');
            
            $return                 = ReturnDocument::where('debet_id', $department->id)->whereBetween('date', [$date_begin, $date_end])->get();
            $return_sum             = $return->sum('sum1');
        
            $total_outcome          = $sales_revenue_sum + $transfer_outcome_sum + $markdown_sum + $writedown_sum + $expense_sum + $return_sum;
            $outcome_rest           = $income_rest + $total_income - $total_outcome;
           
            $departments_income = $transfer_income->groupBy('department_gives.name')->map(function ($row) {
                return $row->sum('sum2');
            })->sortDesc()->toArray();


            $departments_outcome = $transfer_outcome->groupBy('department_takes.name')->map(function ($row) {
                return $row->sum('sum1');
            })->sortDesc()->toArray();
            // dd($department_takes);
            
            
            $turns['departmentId']                      =   $department->id;
            $turns['department']                        =   $department->name;
            $turns['dateBegin']                         =   $date_begin;
            $turns['incomeRest']                        =   $income_rest;

            $turns['credit']['total']                   =   $total_income;
            $turns['credit']['income']                  =   $income_sum;
            $turns['credit']['transfer']['total']       =   $transfer_income_sum;
            $turns['credit']['transfer']['departments'] =   $departments_income;
            $turns['credit']['markup']                  =   $markup_sum;

            $turns['debet']['total']                    =   $total_outcome;
            $turns['debet']['sales']                    =   $sales_revenue_sum;
            $turns['debet']['transfer']['total']        =   $transfer_outcome_sum;            
            $turns['debet']['transfer']['departments']  =   $departments_outcome;
                        
            $turns['debet']['markdown']                 =   $markdown_sum;
            $turns['debet']['writedown']                =   $writedown_sum;
            $turns['debet']['expense']                  =   $expense_sum;
            $turns['debet']['return']                   =   $return_sum;

            $turns['dateEnd']                           =   $date_end;
            $turns['outcomeRest']                       =   $outcome_rest; 
            
            if ($set_rest == 1) {
                $department->setRest($date_begin, $outcome_rest);
            }
        // }       
        
       return $turns;
            
        // return new DepartmentTurnsResource($turns);
    }
}
