<?php

namespace Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SalaryTypeTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
                
        $this->url = '/api/salary-types';
    }

    public function test_api_should_return_types()
    {
        $this->model->instance('SalaryType')->create(3);

        $response = $this->get($this->url, $this->httpHeaders)->getData();

        $this->assertCount(3, $response->data);
    }

    public function test_api_should_return_single_type()
    {
        $type = $this->model->instance('SalaryType')->override(['code' => 'salary'])->create();

        $response = $this->get($type->path(), $this->httpHeaders)->getData();

        $this->assertEquals($response->data->code, $type->code);
    }
}
