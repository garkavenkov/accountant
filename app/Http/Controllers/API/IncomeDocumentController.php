<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\IncomeDocument;
use App\Services\DocumentService;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\IncomeDocumentRequest;
use App\Http\Resources\API\IncomeDocument\IncomeDocumentResource;
use App\Http\Resources\API\IncomeDocument\IncomeDocumentResourceCollection;

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
        $parameters['with']         = 'employee,supplier,department';
        
        if (request()->input('per_page')) {
            $per_page = request()->input('per_page');
        } else {
            $per_page = 10;
        }
        
        $data = $this->documents->get(IncomeDocument::class, $parameters);
        
        // if (request()->input('per_page')) {
        //     $per_page = request()->input('per_page');
        // } else {
        //     $per_page = 10;
        // }
        
        // $documents  = IncomeDocument::with('employee', 'supplier', 'department')->paginate($per_page);
        
        return new IncomeDocumentResourceCollection($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        
        $document = IncomeDocument::create([
            'date'              =>  $validated['date'],
            'debit_id'          =>  $validated['debit_id'],
            'credit_id'         =>  $validated['credit_id'],
            'credit_person_id'  =>  $validated['credit_person_id'],
            'sum1'              =>  $validated['sum1'],
            'sum2'              =>  $validated['sum2'],
            // 'user_id'           =>  \Auth::id(),
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
        IncomeDocument::findOrFail($id)->delete();
        
        return response()->json(['message' => 'Document has been successfully deleted!'], 200);
    }
}
