<?php

namespace Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmployeeTest extends TestCase
{
    use RefreshDatabase;

    private $url;    

    public function setUp(): void
    {
        parent::setUp();
                
        $this->url = '/api/employees';
    }

    public function test_api_should_return_employees()
    {
        $this->model->instance('Employee')->create(5);

        $response = $this->get($this->url, $this->httpHeaders)->getData();

        $this->assertCount(5, $response);
    }

    public function test_api_should_return_an_employee()
    {
        $employee = $this->model->instance('Employee')->create();
        $response = $this->get($employee->path(), $this->httpHeaders)->getData();        
        
        $this->assertEquals($employee->surname, $response->data->surname);
    }
}
