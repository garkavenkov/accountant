<?php

namespace Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReturnDocumentTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
                
        $this->url = '/api/return-documents';
        $this->document_type    = $this->model->instance('DocumentType')->override(['code' => 'return'])->create();
    }

    public function test_api_should_return_documents()
    {
        $this->model->instance('ReturnDocument')->override(['document_type_id' => $this->document_type->id])->create(5);

        $response = $this->get($this->url, $this->httpHeaders)->getData();
        
        $this->assertCount(5, $response->data);
    }

    public function test_api_should_return_single_document()
    {
        $doc = $this->model
                    ->instance('ReturnDocument')
                    ->override(['document_type_id' => $this->document_type->id])
                    ->create();

        $response = $this->get($doc->path(), $this->httpHeaders)->getData();
        
        $this->assertEquals($response->data->purchaseSum, $doc->sum1);
    }
}
