<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Services\DocumentService;
use App\Models\CashProfitDocument;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\CashProfitDocumentRequest;
use App\Http\Resources\API\CashProfit\CashProfitDocumentResource;
use App\Http\Resources\API\CashProfit\CashProfitDocumentResourceCollection;

class CashProfitDocumentController extends Controller
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
        $parameters['with'] = 'cash_credit,profit,operation';

        $data = $this->documents->get(CashProfitDocument::class, $parameters);

        // $data = CashExpenseDocument::all();
        
        return new CashProfitDocumentResourceCollection($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CashProfitDocumentRequest $request)
    {
        $validated = $request->validated();

        $doc = CashProfitDocument::create($validated);

        return new CashProfitDocumentResource($doc);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
}
