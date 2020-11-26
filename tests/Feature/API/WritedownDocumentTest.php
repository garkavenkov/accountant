<?php

namespace Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WritedownDocumentTest extends TestCase
{
    private $document_type;

    public function setUp(): void
    {
        parent::setUp();
                
        $this->url = '/api/writedown-documents';

        $this->document_type = $this->model->instance('DocumentType')->override(['code' => 'writedown'])->create();
    }

    public function test_api_should_return_document()
    {
        
        $this->model->instance('WritedownDocument')->override(['document_type_id' => $this->document_type->id])->create();
        
        $response = $this->get($this->url, $this->httpHeaders)->getData();

        $this->assertCount(1, $response->data);
    }

}
