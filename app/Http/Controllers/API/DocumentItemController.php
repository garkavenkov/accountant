<?php

namespace App\Http\Controllers\API;

use App\Models\DocumentItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\DocumentItemRequest;
use App\Http\Resources\API\DocumentItem\DocumentItemResource;

class DocumentItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\API\DocumentItemRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DocumentItemRequest $request)
    {   
        $validated = $request->validated();

        $item = DocumentItem::create([
            'document_id'   =>  $request->document_id,
            'name'          =>  $validated['name'],
            'measure_id'    =>  $validated['measure_id'],
            'quantity'      =>  $validated['quantity'],
            'price'         =>  $validated['price'],
            'price2'        =>  $validated['price2'],
        ]);
        
        if ($item) {
            return response()->json($item, 201);
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
        $item = DocumentItem::findOrFail($id);

        return new DocumentItemResource($item);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\API\DocumentItemRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DocumentItemRequest $request, $id)
    // public function update(Request $request, $id)
    {   
        $validated = $request->validated();
        
        $item = DocumentItem::findOrFail($id);
        // dd($request->all());
        // $item->update($request->all());
        $item->update([
            'document_id'   =>  $request->document_id,
            'name'          =>  $validated['name'],
            'measure_id'    =>  $validated['measure_id'],
            'quantity'      =>  $validated['quantity'],
            'price'         =>  $validated['price'],
            'price2'        =>  $validated['price2'],
        ]);
        
        if ($item) {
            return response()->json($item, 201);
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
        DocumentItem::findOrFail($id)->delete();

        return response()->json([], 204);
    }
}
