<?php

namespace App\Http\Controllers\API;

use App\Models\CashDocument;
use Illuminate\Http\Request;
use App\Services\DocumentService;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\CashDocument\CashDocumentResource;
use App\Http\Resources\API\CashDocument\CashDocumentResourceCollection;

class CashDocumentController extends Controller
{
    protected $documents;

    public function __construct(DocumentService $service)
    {
        $this->documents = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return App\Http\Resources\API\CashDocument\CashDocumentResourceCollection;
     */
    public function index()
    {
        $parameters = request()->input();
        
        // $documents = CashDocument::get();
        // dd($documents);
        // return response()->json($documents);

        $data = $this->documents->get(CashDocument::class, $parameters);

        return new CashDocumentResourceCollection($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return App\Http\Resources\API\CashDocument\CashDocumentResource;
     */
    public function show($id)
    {
        $document  = CashDocument::findOrFail($id);

        return new CashDocumentResource($document);
    }


    public function approve($id)
    {
        $document = CashDocument::findOrFail($id);

        if ($document->approve()) {
            return new CashDocumentResource($document);
        }        
    }

    public function storno($id)
    {
        $document = CashDocument::findOrFail($id);

        if ($document->storno()) {
            return new CashDocumentResource($document);
        }        
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
}
