<?php

namespace App\Http\Controllers\API;

use App\Models\DocumentType;
use Illuminate\Http\Request;
use App\Models\ExpenseDocument;
use App\Services\DocumentService;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\ExpenseDocumentRequest;
use App\Http\Resources\API\ExpenseDocument\ExpenseDocumentResource;
use App\Http\Resources\API\ExpenseDocument\ExpenseDocumentResourceCollection;

class ExpenseDocumentController extends Controller
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
        $parameters['with']         = 'department,employee';
        
        if (request()->input('per_page')) {
            $per_page = request()->input('per_page');
        } else {
            $per_page = 10;
        }
        
        $data = $this->documents->get(ExpenseDocument::class, $parameters);

        return new ExpenseDocumentResourceCollection($data);    
    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExpenseDocumentRequest $request)
    {
        $validated = $request->validated();
        
        $document_type = DocumentType::where('code', 'expense')->first();        

        $document = ExpenseDocument::create([
            'date'              =>  $validated['date'],
            'document_type_id'  =>  $document_type->id,
            'debet_id'          =>  $validated['debet_id'],
            'debet_person_id'   =>  $validated['debet_person_id'],
            'sum2'              =>  $validated['sum2'],            
        ]);

        if ($document) {
            return new ExpenseDocumentResource($document);     
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
        $document = ExpenseDocument::with('department','employee', 'items')->findOrFail($id);
   
        return new ExpenseDocumentResource($document);
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
        $document = ExpenseDocument::findOrFail($id);
        
        $document->update($request->all());
        
        if ($document->save()) {
            
            return (new ExpenseDocumentResource($document))
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
        $document = ExpenseDocument::findOrFail($id);

        if ($document->delete()) {
            return response()->json(['message' => 'Document has been successfully deleted!'], 200);
        }
    }
}
