<?php

namespace App\Http\Controllers\API;

use App\Models\Loan;
use App\Models\ContractTurn;
use App\Models\LoanContract;
use Illuminate\Http\Request;
use App\Models\LoanRepayment;
use App\Models\LinkedDocument;
use App\Models\LinkedDocumentType;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\LoanContract\LoanContractResource;
use App\Http\Resources\API\LoanContract\LoanContractResourceCollection;

class LoanContractController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $loans = LoanContract::get();
        
        return new LoanContractResourceCollection($loans);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $loan_contract = LoanContract::create($request->all());
        
        $loan_document = Loan::create([
            'date'      =>  $loan_contract->date_begin,
            'purpose'   =>  $request->purpose,
            'debet_id'  =>  $loan_contract->id,
            'credit_id' =>  $request->cash_id,
            'credit'    =>  $loan_contract->amount
        ]);

        $type = LinkedDocumentType::where('code', 'loan')->first();

        $link = LinkedDocument::create([
            'type_id'               =>  $type->id,
            'cash_document_id'      =>  $loan_document->id,
            'owner_id'              =>  $loan_contract->id
        ]);

        if ($loan_contract) {
            return response()->json(new LoanContractResource($loan_contract), 201);
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
        $loan = LoanContract::with('currency','creditor','repayments')->findOrFail($id);
        
        return new LoanContractResource($loan);
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

    public function repayment(Request $request)
    {
        $loan_contract = LoanContract::findOrFail($request->loan_id);
        
        $loan_document = LoanRepayment::create([
            'date'      =>  $request->date,
            'debet_id'  =>  $request->cash_id,
            'credit_id' =>  $request->loan_id,
            'purpose'   =>  $request->purpose,
            'debet'     =>  $request->amount
        ]);

        $type = LinkedDocumentType::where('code', 'loan_repayment')->first();

        $link = LinkedDocument::create([
            'type_id'               =>  $type->id,
            'cash_document_id'      =>  $loan_document->id,
            'owner_id'              =>  $loan_contract->id
        ]);

        $turn = ContractTurn::create([
            'contract_id'   =>  $loan_contract->id,
            'date'          =>  $request->date,
            'amount'        =>  ($loan_contract->currency->code !== 'RUB') ? $request->amount2 : $request->amount
        ]);

        if ($turn) {
            return response()->json(new LoanContractResource($loan_contract), 201);
        }
    }
}
