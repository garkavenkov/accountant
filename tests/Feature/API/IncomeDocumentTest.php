<?php

namespace Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IncomeDocumentTest extends TestCase
{
    use RefreshDatabase;

    private $url;    

    public function setUp(): void
    {
        parent::setUp();
                
        $this->url = '/api/income-documents';
    }

    public function test_api_should_return_income_documents()
    {
        $this->model->instance('IncomeDocument')->create(5);

        $response = $this->get($this->url, $this->httpHeaders)->getData();

        $this->assertCount(5, $response->data);
    }

    public function test_api_should_return_an_income_document()
    {
        $supplier   = $this->model->instance('Supplier')->create();
        $department = $this->model->instance('Department')->create();

        $document = $this->model->instance('IncomeDocument')
                                ->override([
                                    'debit_id'  =>  $supplier->id,
                                    'credit_id' =>  $department->id,
                                    'sum1'      =>  1000,
                                    'sum2'      =>  1200,
                                ])
                                ->create();

        $response = $this->get($document->path(), $this->httpHeaders)->getData();
        
        $this->assertEquals($response->data->gain, 200);
    }
 
    public function test_api_should_delete_a_document()
    {
        $document = $this->model->instance('IncomeDocument')->create();

        $this->delete($document->path(),  [] ,$this->httpHeaders)->assertStatus(200);

        $this->assertDatabaseMissing('documents', [
            'id'    =>  $document->id
        ]);
    }

    public function test_api_should_create_a_document()
    {
        $document = $this->model->instance('IncomeDocument')->makeArray();

        $response = $this->post($this->url, $document, $this->httpHeaders)->assertStatus(201);

        $this->assertDatabaseHas('documents', $document);
        $this->assertEquals($response->getData()->sum1, $document['sum1']);
    }

    public function test_api_should_return_an_error_if_date_is_not_set()
    {
        $document = $this->model->instance('IncomeDocument')->override(['date' => null])->makeArray();
        
        $this->post($this->url, $document, $this->httpHeaders)->assertSessionHasErrors('date');
    }

    public function test_api_should_return_an_error_if_supplier_is_not_exists()
    {
        $document = $this->model->instance('IncomeDocument')->override(['debit_id' => 0])->makeArray();
        
        $this->post($this->url, $document, $this->httpHeaders)->assertSessionHasErrors('debit_id');        
    }

    public function test_api_should_return_an_error_if_department_is_not_exists()
    {
        $document = $this->model->instance('IncomeDocument')->override(['credit_id' => 0])->makeArray();
        
        $this->post($this->url, $document, $this->httpHeaders)->assertSessionHasErrors('credit_id');
    }
    
    public function test_api_should_return_an_error_if_employee_is_not_exists()
    {
        $document = $this->model->instance('IncomeDocument')->override(['credit_person_id' => 0])->makeArray();
        
        $this->post($this->url, $document, $this->httpHeaders)->assertSessionHasErrors('credit_person_id');
    }

    public function test_api_should_return_an_error_if_purchaseSum_is_less_than_zero()
    {
        $document = $this->model->instance('IncomeDocument')->override(['sum1' => -5])->makeArray();
        
        $this->post($this->url, $document, $this->httpHeaders)->assertSessionHasErrors('sum1');
    }

    public function test_api_should_return_an_error_if_retailSum_is_less_than_purchaseSum()
    {
        $document = $this->model->instance('IncomeDocument')->override(['sum1' => 10, 'sum2' => 5])->makeArray();
        
        $this->post($this->url, $document, $this->httpHeaders)->assertSessionHasErrors('sum2');
    }

    public function test_api_should_update_an_income_document()
    {
        $document = $this->model->instance('IncomeDocument')->create();

        $attr['sum1'] = 100;

        $this->patch($document->path(), $attr, $this->httpHeaders)->assertStatus(201);

        $response = $this->get($document->path(), $this->httpHeaders)->getData();

        $this->assertEquals($response->data->sum1, $attr['sum1']);
    }
}
