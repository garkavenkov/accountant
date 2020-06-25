<?php

namespace Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DepartmentTest extends TestCase
{
    use RefreshDatabase;

    private $url;    

    public function setUp(): void
    {
        parent::setUp();
                
        $this->url = '/api/departments';
    }

    public function test_api_should_return_departments()
    {
        $this->model->instance('Department')->create(5);

        $response = $this->get($this->url, $this->httpHeaders)->getData();
        
        $this->assertCount(5, $response);
    }

    public function test_api_should_return_department()
    {
        $department = $this->model->instance('Department')->create();
        
        $response = $this->get($department->path(), $this->httpHeaders)->getData();
        
        $this->assertEquals($department->name, $response->name);
    }
}
