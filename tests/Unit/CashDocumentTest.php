<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\CashDocument;

class CashDocumentTest extends TestCase
{
    private $operation;

    public function setUp(): void
    {
        parent::setUp();

        $this->url = '/api/cash-documents';

        $this->operation = $this->model->instance('CashOperation')->override(['code' => 'sales_revenue'])->create();
    }

    public function test_approve_cash_document()
    {
        $this->model->instance('SalesRevenue')
                    ->override([
                        'date'          => Carbon::now()->toDateString(),
                        'operation_id'  => $this->operation->id,
                        'credit'        =>  1000
                    ])
                    ->create();
     
        $document = CashDocument::first();

        $document->approve();
        
        $this->assertEquals(1, $document->status);
    }

    public function test_refuse_cash_document()
    {
        $this->model->instance('SalesRevenue')
                    ->override([
                        'date'          => Carbon::now()->toDateString(),
                        'operation_id'  => $this->operation->id,
                        'credit'        =>  1000
                    ])
                    ->create();
     
        $document = CashDocument::first();

        $document->storno();
        
        $this->assertEquals(0, $document->status);
    }

}
