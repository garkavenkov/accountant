<?php

namespace Tests\Feature\API;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CashDocumentTest extends TestCase
{
    use RefreshDatabase;

    private $operation;    

    public function setUp(): void
    {
        parent::setUp();
                
        $this->url = '/api/cash-documents';
        
        $this->operation = $this->model->instance('CashOperation')->override(['code' => 'sales_revenue'])->create();
    }

    public function test_api_should_return_cash_documents()
    {
        $this->model->instance('SalesRevenue')
                ->override([
                    'date' => Carbon::now()->toDateString(),
                    'operation_id' => $this->operation->id
                ])
                ->create(5);
        
        $response = $this->get($this->url, $this->httpHeaders)->getData();
        
        $this->assertCount(5, $response->data);
    }

    public function test_api_should_return_a_document()
    {
        $document = $this->model->instance('SalesRevenue')
                                ->override([
                                    'date'          => Carbon::now()->toDateString(),
                                    'operation_id'  => $this->operation->id,
                                    'credit'        =>  1000
                                ])
                                ->create();
        
        $response = $this->get($document->path($this->url), $this->httpHeaders)->getData();
        
        $this->assertEquals($response->data->credit, $document->credit);
    }
}
