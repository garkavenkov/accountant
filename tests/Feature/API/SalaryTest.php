<?php

namespace Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SalaryTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
                
        $this->url = '/api/salaries';

        $this->operation = $this->model->instance('CashOperation')->override(['code' => 'salary'])->create();
    }

    public function test_api_should_return_salaries_documents()
    {
        $this->model->instance('Salary')->create(5);
        
        $response = $this->get($this->url, $this->httpHeaders)->getData();

        $this->assertCount(5, $response->data);
    }

    public function test_api_should_return_single_document()
    {
        $doc = $this->model->instance('Salary')->create();
        
        $response = $this->get($doc->path(), $this->httpHeaders)->getData();

        $this->assertEquals($response->data->amount, $doc->debet);
    }

    public function test_api_should_create_a_document()
    {
        $doc = $this->model->instance('Salary')->override(['operation_id' => $this->operation->id])->makeArray();
        
        $response = $this->post($this->url, $doc, $this->httpHeaders)->assertStatus(201);        
        
        $this->assertEquals($response->getData()->purpose, $doc['purpose']);
    }
}
