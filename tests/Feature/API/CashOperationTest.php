<?php

namespace Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CashOperationTest extends TestCase
{
    use RefreshDatabase;

    private $url;    

    public function setUp(): void
    {
        parent::setUp();
                
        $this->url = '/api/cash-operations';
    }

    public function test_api_should_return_cash_operations()
    {
        $this->model->instance('CashOperation')->create(5);

        $response = $this->get($this->url, $this->httpHeaders)->getData();
        
        $this->assertCount(5, $response->data);
    }

    public function test_api_should_return_a_cash_operation()
    {
        $operation = $this->model->instance('CashOperation')->create();

        $response = $this->get($operation->path(), $this->httpHeaders)->getData();
        
        $this->assertEquals($operation->name, $response->data->name);
    }

}
