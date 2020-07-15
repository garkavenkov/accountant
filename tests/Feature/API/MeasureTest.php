<?php

namespace Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MeasureTest extends TestCase
{
    use RefreshDatabase;

    private $url;    

    public function setUp(): void
    {
        parent::setUp();
                
        $this->url = '/api/measures';
    }

    public function test_api_should_return_measures()
    {
        $this->model->instance('Measure')->create(5);

        $response = $this->get($this->url, $this->httpHeaders)->getData();

        $this->assertCount(5, $response);
    }
}
