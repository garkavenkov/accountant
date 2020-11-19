<?php

namespace App\Http\Controllers\API;

use App\Models\Document;
use Illuminate\Http\Request;
use App\Models\TransferDocument;
use App\Services\DocumentService;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\TransferDocumentRequest;
use App\Http\Resources\API\TransferDocument\TransferDocumentResource;
use App\Http\Resources\API\TransferDocument\TransferDocumentResourceCollection;

class TransferDocumentController extends Controller
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
        $parameters['with']         = 'department_gives,department_takes,employee_gives,employee_takes';
        
        if (request()->input('per_page')) {
            $per_page = request()->input('per_page');
        } else {
            $per_page = 10;
        }
        
        $data = $this->documents->get(TransferDocument::class, $parameters);
        // dd($data);
        return new TransferDocumentResourceCollection($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TransferDocumentRequest $request)
    {
        $validated = $request->validated();
        
        $document = TransferDocument::create([
            'date'              =>  $validated['date'],
            'debet_id'          =>  $validated['debet_id'],
            'debet_person_id'   =>  $validated['debet_person_id'],
            'credit_id'         =>  $validated['credit_id'],
            'credit_person_id'  =>  $validated['credit_person_id'],
            'sum1'              =>  $validated['sum1'],
            'sum2'              =>  $validated['sum2'],            
        ]);
                
        if ($document) {
            return new TransferDocumentResource($document);
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
        $document = TransferDocument::with('department_gives','department_takes','employee_gives','employee_takes', 'items')
                            ->findOrFail($id);
        
        return new TransferDocumentResource($document);
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
        // dd($request);
        // $validated = $request->validated();
        // dd($validated);
        $document = TransferDocument::findOrFail($id);
        $document->update($request->all());
        $document->save();
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
}
