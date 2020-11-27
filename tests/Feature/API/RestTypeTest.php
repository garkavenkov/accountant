<?php

namespace Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RestTypeTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
                
        $this->url = '/api/rest-types';
    }

    public function test_api_should_return_rest_types()
    {
        $this->model->instance('RestType')->create(2);

        $response = $this->get($this->url, $this->httpHeaders)->getData();

        $this->assertCount(2, $response->data);
    }

    public function test_api_should_resturn_rest()
    {
        $type = $this->model->instance('RestType')->create();
        
        $response = $this->get($type->path(), $this->httpHeaders)->getData();
        
        $this->assertEquals($response->data->code, $type->code);
    }
}
