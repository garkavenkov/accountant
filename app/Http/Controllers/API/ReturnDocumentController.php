<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\ReturnDocument;
use App\Services\DocumentService;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\ReturnDocumentRequest;
use App\Http\Resources\API\ReturnDocument\ReturnDocumentResource;
use App\Http\Resources\API\ReturnDocument\ReturnDocumentResourceCollection;

class ReturnDocumentController extends Controller
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
        $parameters['with']         = 'supplier,department,employee';
        
        // if (request()->input('per_page')) {
        //     $per_page = request()->input('per_page');
        // } else {
        //     $per_page = 10;
        // }
        // $data = ReturnDocument::all();
        $data = $this->documents->get(ReturnDocument::class, $parameters);
        
        // if (request()->input('per_page')) {
        //     $per_page = request()->input('per_page');
        // } else {
        //     $per_page = 10;
        // }
        
        return new ReturnDocumentResourceCollection($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReturnDocumentRequest $request)
    {
        $validated  = $request->validated();

        $doc = ReturnDocument::create($validated);

        return new ReturnDocumentResource($doc);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $doc = ReturnDocument::findOrFail($id);
        
        return new ReturnDocumentResource($doc);
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
        $document = ReturnDocument::findOrFail($id);

        if ($document->delete()) {
            return response()->json(['message' => 'Документ был успешно удален'], 200);
        }
    }
}
