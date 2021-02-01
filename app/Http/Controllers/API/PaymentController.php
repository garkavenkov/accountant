<?php

namespace App\Http\Controllers\API;

use App\Models\Cash;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Models\IncomeDocument;
use App\Models\LinkedDocument;
use App\Services\DocumentService;
use App\Models\LinkedDocumentType;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\Payment\PaymentResource;
use App\Http\Resources\API\Payment\PaymentResourceCollection;

class PaymentController extends Controller
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
        // $parameters['with']         = 'cash,supplier';
        
        if (request()->input('per_page')) {
            $per_page = request()->input('per_page');
        } else {
            $per_page = 10;
        }
        
        $data = $this->documents->get(Payment::class, $parameters);
        // dd($data);
        // return response()->json($data);
        return new PaymentResourceCollection($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
      
        DB::beginTransaction();

        try {
        // DB::transaction(function () use($request) {

            $payment = new Payment([
                'date'              =>  $request->date,
                'debet_id'          =>  $request->debet_id,
                'credit_id'         =>  $request->credit_id,            
                'purpose'           =>  $request->purpose,
                'debet'             =>  $request->debet            
            ]);

            $payment->save();

            $ids = [];

            if ($request->ids) {
                $ids = explode(',', $request->ids);
            }

            if (count($ids) > 0) {
                $link_type = LinkedDocumentType::where('code', 'payment')->first();

                for ($i = 0; $i<count($ids); $i++) {
                    $link = new LinkedDocument([
                        'type_id'           =>  $link_type->id,
                        'cash_document_id'  =>  $payment->id,
                        'owner_id'          =>  $ids[$i]
                    ]);

                    if ($link->save()) {
                        $document = IncomeDocument::findOrFail($ids[$i]);
                        $document->status = 1;
                        $document->save();
                    }
                }
            }
            
        } catch (\Exception $e) {
            DB::rollback();
        }
        
        DB::commit();

        return response()->json($payment, 201);        
        
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $payment = Payment::with('documents')->findOrFail($id);
        // dd($payment);
        return new PaymentResource($payment);
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
        $payment = Payment::findOrFail($id);

        DB::beginTransaction();

        try {
            // dd($payment);
            if ($payment->status == 1) {
                throw new \Exception('Document is aprove. For deleting payment storno document');
            }

            if ($payment->links()->count() > 0) {

            
                foreach ($payment->links as $link) {
                    $link->income_document->unpaid();
                }
            }
       
            $payment->delete();
            
            DB::commit();
            return response()->json(['message' => 'Document has been successfully deleted!'], 200);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 404);
        }
       
    }

    public function getUnlinkedPayments()
    {
        $parameters = request()->input();
        
        if (isset($parameters['cash_id'])) {
            $cash_id = $parameters['cash_id'];
        } else {
            $cash_id = 0;
        }
        
        if (isset($parameters['date_begin'])) {
            $date_begin = $parameters['date_begin'];
        } else {
            $date_begin = Carbon::now()->formatLocalized('%Y-%m-%d');
        }

        if (isset($parameters['date_end'])) {
            $date_end = $parameters['date_end'];
        } else {
            $date_end = $date_begin;
        }

        if (isset($parameters['supplier_id'])) {
            $supplier_id = $parameters['supplier_id'];
        } else {
            $supplier_id = 0;
        }

        if ($cash_id != 0) {
            $cash = Cash::findOrFail($cash_id);
        }
     
        
        $payments = Payment::with('cash.branch', 'supplier')
                            ->whereBetween('date',[$date_begin, $date_end])
                            ->where(function($query) use($cash_id) {
                                    $query->where('debet_id', $cash_id)
                                            ->orWhereRaw("0 = $cash_id");
                            })
                            ->where(function($query) use($supplier_id) {
                                $query->where('credit_id', $supplier_id)
                                        ->orWhereRaw("0 = $supplier_id");
                            })
                            ->whereDoesntHave('links')
                            ->get();

        return new PaymentResourceCollection($payments);
    }
}
