<?php

namespace Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShiftTest extends TestCase
{
    use RefreshDatabase;

    private $url;    

    public function setUp(): void
    {
        parent::setUp();
                
        $this->url = '/api/shifts';
    }

    public function test_api_should_return_shifts()
    {
        $this->model->instance('Shift')->create(5);

        $response = $this->get($this->url, $this->httpHeaders)->getData();
        
        $this->assertCount(5, $response);
    }

    public function test_api_should_return_a_shift()
    {
        $shift = $this->model->instance('Shift')->create();
        
        $response = $this->get($this->url, $this->httpHeaders)->getData();
        // dd($response->data);
        $this->assertEquals($response->data[0]->department, $shift->department->name);
    }
}
