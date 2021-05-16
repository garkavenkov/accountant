<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Services\DocumentService;
use App\Models\CashExpenseDocument;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\CashExpenseDocumentRequest;
use App\Http\Resources\API\CashExpense\CashExpenseDocumentResource;
use App\Http\Resources\API\CashExpense\CashExpenseDocumentResourceCollection;

class CashExpenseDocumentController extends Controller
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
        $parameters['with'] = 'cash_debet,operation,expense.category.group';

        $data = $this->documents->get(CashExpenseDocument::class, $parameters);

        // $data = CashExpenseDocument::all();
        
        return new CashExpenseDocumentResourceCollection($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CashExpenseDocumentRequest $request)
    {
        $validated = $request->validated();

        $doc = CashExpenseDocument::create($validated);

        return new CashExpenseDocumentResource($doc);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $document = CashExpenseDocument::findOrFail($id);

        return new CashExpenseDocumentResource($document);
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
        $doc = CashExpenseDocument::findOrFail($id);

        if ($doc->delete()) {
            return response()->json(['message' => 'Документ успешно удален'], 200);
        }

    }
}
