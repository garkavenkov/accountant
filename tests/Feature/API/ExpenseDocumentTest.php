<?php

namespace Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ExpenseDocumentTest extends TestCase
{
    use RefreshDatabase;

    private $document_type;

    public function setUp(): void
    {
        parent::setUp();
                
        $this->url = '/api/expense-documents';

        $this->document_type = $this->model->instance('DocumentType')->override(['code' => 'expense'])->create();
    }

    public function test_api_should_return_documents()
    {
        $docs = $this->model->instance('ExpenseDocument')->override(['document_type_id' => $this->document_type->id])->create(5);
        
        $response = $this->get($this->url, $this->httpHeaders)->getData();
        
        $this->assertCount(5, $response->data);
    }

    public function test_api_should_return_single_document()
    {
        $document = $this->model->instance('ExpenseDocument')->override(['document_type_id' => $this->document_type->id])->create();
        
        $response = $this->get($document->path(), $this->httpHeaders)->getData();
        
        $this->assertEquals($response->data->expenseSum, $document->sum2);
    }

    public function test_api_should_create_document()
    {
        $doc = $this->model->instance('ExpenseDocument')->override(['document_type_id'=> $this->document_type->id])->makeArray();

        $response = $this->post($this->url, $doc, $this->httpHeaders)->assertStatus(201);

        $this->assertDatabaseHas('documents', $doc);
    }

    public function test_api_should_delete_a_document()
    {
        $doc = $this->model->instance('ExpenseDocument')->create();

        $this->delete($document->path(),  [] ,$this->httpHeaders)->assertStatus(200);

        $this->assertDatabaseMissing('documents', [
            'id'    =>  $document->id
        ]);        
        
    }
}
