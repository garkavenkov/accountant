<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\Branch;
use App\Models\Document;
use App\Models\DocumentType;
use Illuminate\Http\Request;
use App\Models\Accountability;
use App\Models\IncomeDocument;
use App\Services\DocumentService;
use App\Models\AccountabilityItem;
use App\Http\Controllers\Controller;
use App\Models\AccountabilityItemType;
use App\Http\Requests\API\IncomeDocumentRequest;
use App\Http\Resources\API\IncomeDocument\IncomeDocumentResource;
use App\Http\Resources\API\IncomeDocument\IncomeDocumentResourceCollection;
use App\Http\Resources\API\IncomeDocument\UnpaidIncomeDocumentResourceCollection;

class IncomeDocumentController extends Controller
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
        $parameters['with']         = 'employee,supplier,department,payments,accountability';
        
        // if (request()->input('per_page')) {
        //     $per_page = request()->input('per_page');
        // } else {
        //     $per_page = 10;
        // }
        
        $data = $this->documents->get(IncomeDocument::class, $parameters);
        
        // if (request()->input('per_page')) {
        //     $per_page = request()->input('per_page');
        // } else {
        //     $per_page = 10;
        // }
        
        // $documents  = IncomeDocument::with('employee', 'supplier', 'department')->paginate($per_page);
        // return response()->json($data);
        return new IncomeDocumentResourceCollection($data);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\API\IncomeDocumentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(IncomeDocumentRequest $request)    
    {        
        
        $validated = $request->validated();
        
        $document_type = DocumentType::where('code', 'income')->first();        

        $document = IncomeDocument::create([
            'date'              =>  $validated['date'],
            'document_type_id'  =>  $document_type->id,
            'debet_id'          =>  $validated['debet_id'],
            'credit_id'         =>  $validated['credit_id'],
            'credit_person_id'  =>  $validated['credit_person_id'],
            'sum1'              =>  $validated['sum1'],
            'sum2'              =>  $validated['sum2'],
        ]);
        
        if ($document) {
            // return new IncomeDocumentResource($document);
            return response()->json($document, 201);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $document = IncomeDocument::with('items')->findOrFail($id);

        return new IncomeDocumentResource($document);
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
        $document = IncomeDocument::findOrFail($id);
        // dd($request->all());
        $document->update($request->all());
        
        // dd($document);
        if ($document->save()) {
            return (new IncomeDocumentResource($document))
                    ->response()
                    ->setStatusCode(201);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            $document = IncomeDocument::findOrFail($id);

            if ($document->payments()->count() > 0) {
                throw new \Exception('Document is already paid. Delete payment for first.');
            }
            
            $document->delete();

            return response()->json(['message' => 'Document has been successfully deleted!'], 200);

        } catch(\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function setFlag()
    {
        $parameters = request()->input();
        
        if (isset($parameters['ids'])) {
            $ids = explode(',', $parameters['ids']);
        }
        
        if (isset($parameters['flags'])) {
            $flags = explode(',', $parameters['flags']);
        }

        $documents = IncomeDocument::find($ids);

        try {
            foreach ($documents as $document) {            
                foreach ($flags as $flag) {
                    $document->setFlag($flag);
                }
            }
            return response()->json(['message' => 'Flag has been successfully settled'], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function getUnpaidDocuments()
    {
        $parameters = request()->input();
        
        if (isset($parameters['branch_id'])) {
            $branch_id = $parameters['branch_id'];
        } else {
            $branch_id = 0;
        }
        
        if (isset($parameters['date_begin'])) {
            $date_begin = $parameters['date_begin'];
        } else {
            $date_begin = Carbon::now()->formatLocalized('%Y-%m-%d');
        }

        if (isset($parameters['date_end'])) {
            $date_end = $parameters['date_end'];
        } else {
            $date_end = $date_begin;
        }

        if (isset($parameters['supplier_id'])) {
            $supplier_id = $parameters['supplier_id'];
        } else {
            $supplier_id = 0;
        }

        if ($branch_id != 0) {
            $branch = Branch::findOrFail($branch_id);
        }
        
        
        $documents = IncomeDocument::unpaid()
                        ->with('department.branch', 'supplier')
                        ->whereBetween('date', [$date_begin, $date_end])
                        ->whereHas('department', function($query) use($branch_id) {
                            $query->where('branch_id', $branch_id)
                                    ->orWhereRaw("0 = $branch_id");
                        })
                        ->where(function($query) use($supplier_id) {
                            $query->where('debet_id', $supplier_id)
                                    ->orWhereRaw("0 = $supplier_id");
                        })
                        ->whereRaw('flag & 2 != 2')
                        ->orderBy('date', 'asc')
                        ->get();

        return new UnpaidIncomeDocumentResourceCollection($documents);
    }

    public function addIntoAccountability(Request $request)
    {
        
        if ($request['cash_document_id']) {
            $accountability = Accountability::findOrFail($request['cash_document_id']);
        } else {
            throw new \Exception('Не указан подотчетный документ', 422);
        }

        if ($request['owner_id']) {
            $id = \explode(',', $request['owner_id']);
            $documents = IncomeDocument::findOrFail($id);
        } else {
            // throw new \Exception('Не указана товарная накладная', 422);
            return response()->json(['error' => 'Не указана товарная накладная'], 422);
        }
              
        $type = AccountabilityItemType::where('code', 'income')->first();
        
        if (!$type) {
            return response()->json(['error' => 'AccountabilityItemType not found'], 422);
            // throw new Exception('AccountabilityItemType not found', 10012);
        }
        $count = 0;
        
        foreach ($documents as $document) {
            $purpose = "Товарная накладная на '{$document->department->name}' от " . Carbon::parse($document->date)->formatLocalized('%d.%m.%Y');

            
            $item = AccountabilityItem::create([
                'cash_document_id'  =>  $accountability->id,
                'owner_id'          =>  $document->id,
                'type_id'           =>  $type->id,
                'amount'            =>  $document->sum1,
                'purpose'           =>  $purpose
            ]);

            if ($item) {
                $document->setStatus('inAccountability');
            }
            $count++;
        }

        if ($count > 0) {
            return response()->json(['message' => "$count documents successfulle added"], 201);
        }
    }

    public function report()
    {
        $result = [];
        
        $data = IncomeDocument::with('supplier', 'department')                        
                        ->whereRaw('flag & 1 = 1')
                        ->whereBetween('date', ['2021-01-01', '2021-01-31'])
                        ->get()
                        ->groupBy([
                            'debet_id' => function($s) {
                                return $s->supplier->name;
                            } 
                            // 'credit_id' => function($d) {
                            //     return $d->department->name;
                            // }
                        ])
                        ->sortBy('suppliers.name')
                        // ->sortBy('departments.name')
                        ->sortBy('documents.date');
                        // ->sortBy('documents.sum1');
        
        // dd($data);
        // foreach ($data as $supplier => $deparments_documents) {
        foreach ($data as $supplier => $documents) { 
            // $result[$supplier]['departments'] = array();
            $result[$supplier]['documents'] = array();
            
            $supplier_total = 0;
            $supplier_total_documents = 0;

            // foreach ($deparments_documents as $department => $documents) {

            //     $result[$supplier]['departments'][$department] = array();

            //     $department_total = 0;

                foreach ($documents as $document) {

                    // $department_total += $document->sum1;                    
                    
                    // $result[$supplier]['departments'][$department]['documents'][] = [
                    //     'date'      => Carbon::parse($document->date)->formatLocalized('%d.%m.%Y'),
                    //     'amount'    => $document->sum1,
                    // ];
                    $result[$supplier]['documents'][] = [
                        'department'    => $document->department->name,
                        'date'          => Carbon::parse($document->date)->formatLocalized('%d.%m.%Y'),
                        'amount'        => $document->sum1,
                    ];
                }

                // $supplier_total_documents += count($documents);
                // $supplier_total = $documents->sum('sum1');

                // $result[$supplier]['departments'][$department]['department_total_documents'] = count($documents);
                // $result[$supplier]['departments'][$department]['department_total_amount'] = $department_total;
                // $supplier_total += $department_total;
            // }
            $result[$supplier]['supplier_total_amount']     = $documents->count(); //$supplier_total;
            $result[$supplier]['supplier_total_documents']  = $documents->sum('sum1'); //$supplier_total_documents;

        }

        ksort($result);
        
        return response()->json($result, 200);
    }
}
