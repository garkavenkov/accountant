<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\IncomeDocument;
use App\Models\AccountabilityItem;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\AccountabilityItemRequest;

class AccountabilityItemController extends Controller
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AccountabilityItemRequest $request)
    {      
        $validated = $request->validated();
        // dd($validated);
        $item = AccountabilityItem::create(
            [
                'cash_document_id'  =>  $request['cash_document_id'],
                'type_id'           =>  $request['type_id'],
                'owner_id'          =>  $request['owner_id'],
                'purpose'           =>  $request['purpose'],
                'amount'            =>  $request['amount']
            ]        
        );
        
        return \response()->json(['message' => 'OK!!!'], 201);
        
        // $cash_document_id    > exists in cash_documents
        // $type_id             > exists in accountability_item_type
        // $owner_id            > exists in dictionary* 
        // $amount > 0
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
        
        $item = AccountabilityItem::findOrFail($id);
        
        try {

            if ($item->type->code == 'income') {
                $document = IncomeDocument::findOrFail($item->owner_id);
        
            }

            $document->unsetStatus('inAccountability');
        
            $item->delete();

            return respose()->json(['message' => 'Запись успешно удалена'], 201);
        } catch (\Throwable $th) {
            //throw $th;
        }
        
    }
}
