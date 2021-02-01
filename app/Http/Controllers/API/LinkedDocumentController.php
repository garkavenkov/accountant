<?php

namespace App\Http\Controllers\API;

use App\Models\Payment;
use Illuminate\Http\Request;
use App\Models\IncomeDocument;
use App\Models\LinkedDocument;
use App\Models\LinkedDocumentType;
use App\Http\Controllers\Controller;

class LinkedDocumentController extends Controller
{
    public function linkDocuments(Request $request)
    {
        if (isset($request['data'])) {
            $pairs = explode(';', $request['data']);
        } else {
            return;
        }
        
        if (isset($request['type'])) {
            $type = LinkedDocumentType::where('code', $request['type'])->first();
            if (is_null($type))  {
                return;
            }
        } else {
            return;
        }

        // $links = 0;
        foreach ($pairs as $pair) {
            $pair = \explode(':', $pair);
            
            $document_ids = \explode(',', $pair[0]);
            $payment_ids  = \explode(',', $pair[1]);
            
            if ((count($document_ids) > 2) && (count($payment_ids) > 2)) {
                return response()->json(['message' => 'Ambiguous combintation'], 422);
            }

            $documents = IncomeDocument::findOrFail($document_ids);
            
            $payments  = Payment::findOrFail($payment_ids);

            $links = [];

            if (count($document_ids) > count($payment_ids)) {
                // Several documents are paid by one payments
                $links = array_map(function($document_id) use($type, $payment_ids) {
                    return [
                        'type_id'           =>  $type->id,
                        'owner_id'          =>  $document_id,
                        'cash_document_id'  =>  $payment_ids[0],
                        'created_at'        =>  date('Y-m-d H:i:s'),
                        'updated_at'        =>  date('Y-m-d H:i:s')
                    ];
                }, $document_ids );
            } else if (count($document_ids) < count($payment_ids)) {
                // Income documents is paid by several payments
                $links = array_map(function($payment_id) use($type, $document_ids) {
                    return [
                        'type_id'           =>  $type->id,
                        'owner_id'          =>  $document_ids[0],
                        'cash_document_id'  =>  $payment_id,
                        'created_at'        =>  date('Y-m-d H:i:s'),
                        'updated_at'        =>  date('Y-m-d H:i:s')
                    ];
                }, $payment_ids );
            } else {
                // One income document - one payment
                $links = [
                    'type_id'           => $type->id,
                    'cash_document_id'  => $payments[0]->id,
                    'owner_id'          => $documents[0]->id,
                    'created_at'        =>  date('Y-m-d H:i:s'),
                    'updated_at'        =>  date('Y-m-d H:i:s')
                ];
            }

            // dd($links);
            
            $linked = LinkedDocument::insert($links);
            // dd($links);

            if ($linked) {
                foreach ($documents as $document) {
                    $document->setStatusIsPaid();
                }
            }            
        }        
        
        return response()->json(['message' => "$linked links successfully created"], 201);
    }
}
