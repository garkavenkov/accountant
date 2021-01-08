<?php

namespace App\Http\Controllers\API;

use App\Models\Department;
use App\Models\CashDocument;
use App\Models\SalesRevenue;
use Illuminate\Http\Request;
use App\Models\CashOperation;
use App\Services\DocumentService;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\SalesRevenueRequest;
use App\Http\Resources\API\SalesRevenue\SalesRevenueResource;
use App\Http\Resources\API\SalesRevenue\SalesRevenueResourceCollection;

class SalesRevenueController extends Controller
{

    protected $documents;

    public function __construct(DocumentService $service)
    {
        $this->documents = $service;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return App\Http\Resources\API\SalesRevenue\SalesRevenueResourceCollection;
     */
    public function index()
    {
        $parameters = request()->input();
        $parameters['with']         = 'department,cash';
        
        if (request()->input('per_page')) {
            $per_page = request()->input('per_page');
        } else {
            $per_page = 10;
        }
        
        $data = $this->documents->get(SalesRevenue::class, $parameters);
        
        // if (request()->input('per_page')) {
        //     $per_page = request()->input('per_page');
        // } else {
        //     $per_page = 10;
        // }
        
        // $documents  = IncomeDocument::with('employee', 'supplier', 'department')->paginate($per_page);
        
        // return new IncomeDocumentResourceCollection($data);
        return new SalesRevenueResourceCollection($data);


        // $documents = SalesRevenue::all();
        
        // return new SalesRevenueResourceCollection($documents);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\API\SalesRevenueRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SalesRevenueRequest $request)
    // public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validated();
        // dd($validated);
        $department = Department::findOrFail($validated['debet_id']);

        $document = SalesRevenue::create([
            'date'              =>  $validated['date'],
            // 'operation_id'      =>  1, //CashOperation::where('code', 'sales_revenue')->first()->id,
            // 'number'            =>  1,           
            'debet_id'          =>  $validated['debet_id'],
            'credit_id'         =>  $validated['credit_id'],
            // 'debet'             =>  0,
            'credit'            =>  $validated['credit'],
            'purpose'           =>  'Сдача торговой выручки от торговой точки "' . $department->name . '"',
            'status'            =>  0,
            // 'user_id'           =>  1
        ]);    
        
        
        // $document = CashDocument::create($request->all());
        // dd($document);
        return response()->json($document, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return App\Http\Resources\API\SalesRevenue\SalesRevenueResource
     */
    public function show($id)
    {
        $document = SalesRevenue::findOrFail($id);
        // dd($document);
        return new SalesRevenueResource($document);
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
        SalesRevenue::findOrFail($id)->delete();
        
        return response()->json(['message' => 'Document has been successfully deleted!'], 200);
    }
}
