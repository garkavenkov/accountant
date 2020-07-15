<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Department;
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

    public function test_department_can_operate_with_goods()
    {
        $this->model->instance('Department')->create(2);
        $this->model->instance('Department')->override(['flag' => 1])->create(2);

        $departments = Department::goods()->get();

        $this->assertCount(2, $departments);
    }

    public function test_department_may_have_shifts()
    {
        $department = $this->model->instance('Department')->create();

        $this->model->instance('Shift')->override($department)->create(5);

        $this->assertCount(5, $department->shifts);
    }

    public function test_department_must_have_a_type()
    {
        $department_type = $this->model->instance('DepartmentType')->override(['code' => 'outlet'])->create();

        $department = $this->model->instance('Department')->override(['department_type_id' => $department_type->id])->create();

        $this->assertEquals($department_type->name, $department->type->name);
    }
}
