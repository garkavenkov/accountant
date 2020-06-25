<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DepartmentTest extends TestCase
{
    use RefreshDatabase;

    private $url;    

    public function setUp(): void
    {
        parent::setUp();

        $this->url = '/api/departments';
    }
    
    public function test_a_department_may_have_employees()
    {
        $department = $this->model->instance('Department')->create();

        $this->model->instance('Employee')->override(['department_id' => $department])->create(5);

        $this->assertCount(5, $department->employees);
    }

    public function test_department_must_have_a_branch()
    {
        $branch = $this->model->instance('Branch')->create();

        $department = $this->model->instance('Department')->override(['branch_id'=> $branch->id])->create();

        $this->assertEquals($branch->name, $department->branch->name);
    }

}
