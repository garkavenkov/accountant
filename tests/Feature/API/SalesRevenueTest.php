<?php

namespace Tests\Feature\API;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\CashOperation;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SalesRevenueTest extends TestCase
{
    private $operation;

    public function setUp(): void
    {
        parent::setUp();
                
        $this->url = '/api/sales-revenues';
        
        $this->operation = $this->model->instance('CashOperation')->override(['code' => 'sales_revenue'])->create();
     
    }


    public function test_api_should_return_sales_revenue_documents()
    {
        $docs = $this->model->instance('SalesRevenue')
                ->override([
                    'date' => Carbon::now()->toDateString(),
                    'operation_id' => $this->operation->id
                ])
                ->create(5);
        
        $response = $this->get($this->url, $this->httpHeaders)->getData();
        
        $this->assertCount(5, $response->data);
    }

    public function test_api_should_return_document()
    {
        $document = $this->model->instance('SalesRevenue')
                    ->override([
                        'operation_id' => $this->operation->id
                    ])
                    ->create();

        $response = $this->get($document->path(), $this->httpHeaders)->getData();
        
        $this->assertEquals($document->credit, $response->data->amount);
    }

    public function test_api_should_create_document()
    {
        $document = $this->model->instance('SalesRevenue')
                    ->override([
                        'operation_id' => $this->operation->id
                    ])
                    ->makeArray();        
        $response = $this->post($this->url, $document, $this->httpHeaders)->assertStatus(201);

        $this->assertDatabaseHas('cash_documents', $document);
    }

    public function test_api_should_delete_document()
    {
        $document = $this->model->instance('SalesRevenue')
                    ->override([
                        'operation_id' => $this->operation->id
                    ])
                    ->create();        

        $this->delete($document->path(), [], $this->httpHeaders)->assertStatus(200);

        $this->assertDatabaseMissing('cash_documents', [
            'id'    =>  $document->id
        ]);
    }
}
