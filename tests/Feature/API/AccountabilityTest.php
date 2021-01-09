<?php

namespace Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AccountabilityTest extends TestCase
{
    use RefreshDatabase;

    private $operation;    

    public function setUp(): void
    {
        parent::setUp();
                
        $this->url = '/api/accountabilities';
        
        $this->operation = $this->model->instance('CashOperation')->override(['code' => 'accountability'])->create();
    }

    public function test_api_should_return_accountabilities()
    {
        $this->model->instance('Accountability')->override(['operation_id' => $this->operation->id])->create(5);
        
        $response = $this->get($this->url, $this->httpHeaders)->getData();
        
        $this->assertCount(5, $response->data);
    }

    public function test_api_should_return_accountability()
    {
        $doc = $this->model->instance('Accountability')->override(['operation_id' => $this->operation->id])->create();
        
        $response = $this->get($doc->path(), $this->httpHeaders)->getData();
        
        $this->assertEquals($response->data->amount, $doc->debet);
    }

}
