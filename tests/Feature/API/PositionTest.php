<?php

namespace Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PositionTest extends TestCase
{
    use RefreshDatabase;

    private $url;    

    public function setUp(): void
    {
        parent::setUp();
                
        $this->url = '/api/positions';
    }

    public function test_api_should_return_positions()
    {
        $this->model->instance('Position')->create(5);

        $response = $this->get($this->url, $this->httpHeaders)->getData();

        $this->assertCount(5, $response);
    }

    public function test_api_should_return_a_position()
    {
        $position = $this->model->instance('Position')->create();

        $response = $this->get($position->path(), $this->httpHeaders)->getData();

        $this->assertEquals($position->name, $response->name);
    }
}
