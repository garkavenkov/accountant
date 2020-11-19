<?php

namespace Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TransferDocumentTest extends TestCase
{
    use RefreshDatabase;

    private $document_type;

    public function setUp(): void
    {
        parent::setUp();
                
        $this->url = '/api/transfer-documents';

        $this->document_type = $this->model->instance('DocumentType')->override(['code' => 'transfer'])->create();
    }

    public function test_api_should_return_documents()
    {
        $docs = $this->model->instance('TransferDocument')->override(['document_type_id' => $this->document_type->id])->create(5);
        
        $response = $this->get($this->url, $this->httpHeaders)->getData();
        
        $this->assertCount(5, $response->data);

    }

    public function test_api_should_return_single_document()
    {
        $document = $this->model->instance('TransferDocument')->override(['document_type_id' => $this->document_type->id])->create();

        $response = $this->get($document->path(), $this->httpHeaders)->getData();
        
        $this->assertEquals($document->debet_id, $response->data->department_gives_id);
    }

    public function test_api_should_create_document()
    {
        $document = $this->model->instance('TransferDocument')->makeArray();
        
        $response = $this->post($this->url, $document, $this->httpHeaders)->assertStatus(201);

        $this->assertDatabaseHas('documents', $document);
        $this->assertEquals($response->getData()->sum1, $document['sum1']);
    }

    public function test_api_should_return_an_error_if_date_is_not_set()
    {
        $document = $this->model->instance('TransferDocument')->override(['date' => null])->makeArray();
        
        $this->post($this->url, $document, $this->httpHeaders)->assertSessionHasErrors('date');
    }

    public function test_api_should_return_an_error_if_department_gives_is_not_exists()
    {
        $document = $this->model->instance('TransferDocument')->override(['debet_id' => 999])->makeArray();
        
        $this->post($this->url, $document, $this->httpHeaders)->assertSessionHasErrors('debet_id');
    }

    public function test_api_should_return_an_error_if_department_takes_is_not_exists()
    {
        $document = $this->model->instance('TransferDocument')->override(['credit_id' => 0])->makeArray();
        
        $this->post($this->url, $document, $this->httpHeaders)->assertSessionHasErrors('credit_id');
    }

    public function test_api_should_return_an_error_if_department_takes_is_the_same_as_department_gives()
    {
        $document = $this->model->instance('TransferDocument')->override(['debet_id' => 1, 'credit_id' =>1])->makeArray();
        
        $this->post($this->url, $document, $this->httpHeaders)->assertSessionHasErrors('credit_id');
    }

    public function test_api_should_return_an_error_if_employee_gives_is_not_exists()
    {
        $document = $this->model->instance('TransferDocument')->override(['debet_person_id' => 0])->makeArray();
        
        $this->post($this->url, $document, $this->httpHeaders)->assertSessionHasErrors('debet_person_id');
    }

    public function test_api_should_return_an_error_if_employee_takes_is_not_exists()
    {
        $document = $this->model->instance('TransferDocument')->override(['credit_person_id' => 0])->makeArray();
        
        $this->post($this->url, $document, $this->httpHeaders)->assertSessionHasErrors('credit_person_id');
    }

    public function test_api_should_return_an_error_if_employee_takes_is_the_same_as_employee_gives()
    {
        $document = $this->model->instance('TransferDocument')->override([ 'debet_person_id' => 5, 'credit_person_id' => 5])->makeArray();
       
        $this->post($this->url, $document, $this->httpHeaders)->assertSessionHasErrors('credit_person_id');
    }

    public function test_api_should_return_an_error_if_given_sum_is_less_than_zero()
    {
        $document = $this->model->instance('TransferDocument')->override(['sum1' => -5])->makeArray();
        
        $this->post($this->url, $document, $this->httpHeaders)->assertSessionHasErrors('sum1');
    }

    public function test_api_should_return_an_error_if_taken_sum_is_less_than_zero()
    {
        $document = $this->model->instance('TransferDocument')->override(['sum2' => -5])->makeArray();
        
        $this->post($this->url, $document, $this->httpHeaders)->assertSessionHasErrors('sum2');
    }

    public function test_api_should_return_an_error_if_taken_sSum_is_less_than_given_sum()
    {
        $document = $this->model->instance('TransferDocument')->override(['sum1' => 10, 'sum2' => 5])->makeArray();
        
        $this->post($this->url, $document, $this->httpHeaders)->assertSessionHasErrors('sum2');
    }

    public function test_api_should_update_document()
    {
        $document = $this->model->instance('TransferDocument')->create();

        $attr['sum1'] = 100;

        $this->patch($document->path(), $attr, $this->httpHeaders)->assertStatus(201);

        $response = $this->get($document->path(), $this->httpHeaders)->getData();
        
        $this->assertEquals($response->data->given_sum, $attr['sum1']);
    }

}
