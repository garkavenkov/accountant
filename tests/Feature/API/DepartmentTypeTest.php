<?php

namespace Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DepartmentTypeTest extends TestCase
{
    use RefreshDatabase;

    private $url;    

    public function setUp(): void
    {
        parent::setUp();
                
        $this->url = '/api/department-types';
    }

    public function test_api_should_return_department_types()
    {
        $this->model->instance('DepartmentType')->create(5);

        $response = $this->get($this->url, $this->httpHeaders)->getData();

        $this->assertCount(5, $response);
    }
}
