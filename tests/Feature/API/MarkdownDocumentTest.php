<?php

namespace Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MarkdownDocumentTest extends TestCase
{
   
    private $document_type;

    public function setUp(): void
    {
        parent::setUp();
                
        $this->url = '/api/markdown-documents';

        $this->document_type = $this->model->instance('DocumentType')->override(['code' => 'markdown'])->create();
    }

    public function test_api_should_return_documents()
    {
        // override(['document_type_id' => $this->document_type->id])->
        $this->model->instance('MarkdownDocument')->create(5);

        $response = $this->get($this->url, $this->httpHeaders)->getData();

        $this->assertCount(5, $response->data);
    }

    public function test_api_should_return_a_single_document()
    {
        $document = $this->model->instance('MarkdownDocument')->create();
        
        $response = $this->get($document->path(), $this->httpHeaders)->getData();
        
        $this->assertEquals($response->data->department_id, $document->debet_id);
    }

    public function test_api_should_create_a_document()
    {     
        $document = $this->model->instance('MarkdownDocument')->makeArray();
     
        $response = $this->post($this->url, $document, $this->httpHeaders)->assertStatus(201);
        
        $this->assertDatabaseHas('documents', $document);
     
    }

    public function test_api_should_delete_a_document()
    {
        $document = $this->model->instance('MarkdownDocument')->create();

        $response = $this->delete($document->path(), [], $this->httpHeaders)->assertStatus(200);

        $this->assertDatabaseMissing('documents', ['id' => $document->id]);
    }

    public function test_api_should_update_document()
    {
        $document = $this->model->instance('MarkdownDocument')->create();

        $attr['sum2'] = 100;

        $this->patch($document->path(), $attr, $this->httpHeaders)->assertStatus(201);

        $response = $this->get($document->path(), $this->httpHeaders)->getData();
        
        $this->assertEquals($response->data->markdownSum, $attr['sum2']);
    }
}
