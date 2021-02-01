<?php

namespace App\Http\Controllers\API;

use App\Models\Document;
use App\Models\DocumentItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\DocumentItemRequest;
use App\Http\Requests\API\DocumentItemCloneRequest;
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
        // dd($validated);
        $item = DocumentItem::create([
            'document_id'   =>  $request->document_id,
            'name'          =>  $validated['name'],
            'measure_id'    =>  $validated['measure_id'],
            'quantity'      =>  $validated['quantity'],
            'price'         =>  isset($validated['price']) ? $validated['price'] : 0,
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
    {  
        
        $validated = $request->validated();
        
        $item = DocumentItem::findOrFail($id);
     
        $item->update([
            'document_id'   =>  $request->document_id,
            'name'          =>  $validated['name'],
            'measure_id'    =>  $validated['measure_id'],
            'quantity'      =>  $validated['quantity'],
            'price'         =>  isset($validated['price']) ? $validated['price'] : 0 ,
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

    public function cloneItem(DocumentItemCloneRequest $request)
    {                
        $request = $request->validated();

        $document = Document::find($request['to']);
        
        $items = DocumentItem::find($request['ids']);
        
        $skip_sum1 = array(
            'expense',
            'writedown'
        );

        $number = $document->items()->count();

        foreach ($items as $item) {
            $number++;
            $clone = new DocumentItem([
                'measure_id'    =>  $item->measure_id,
                'number'        =>  $number,
                'name'          =>  $item->name,
                'quantity'      =>  $item->quantity,
                'price'         =>  in_array($document->type->code, $skip_sum1) ? 0 : $item->sum1,
                'price2'        =>  $item->price2
            ]);
            $document->items()->save($clone);
        }

        return response()->json(['message' => "{$document->items()->count()} items has been successfully cloned"], 201);
    }
}
