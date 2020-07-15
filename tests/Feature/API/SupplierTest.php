<?php

namespace Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SupplierTest extends TestCase
{
    use RefreshDatabase;

    private $url;    

    public function setUp(): void
    {
        parent::setUp();
                
        $this->url = '/api/suppliers';
    }

    public function test_api_should_return_suppliers()
    {
        $this->model->instance('Supplier')->create(5);

        $response = $this->get($this->url, $this->httpHeaders)->getData();

        $this->assertCount(5, $response->data);
    }

    public function test_api_should_return_a_dictionary_for_select()
    {
        $suppliers = $this->model->instance('Supplier')->create(5);
        
        $response = $this->get($this->url . '?select=id,name', $this->httpHeaders)->getData();
        // $response = $this->get($this->url, $this->httpHeaders)->getData();
        // dd($response->data[0]);
        $this->assertObjectNotHasAttribute('full_name', $response->data[0]);
    }
}
