<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmployeeTest extends TestCase
{
    use RefreshDatabase;

    private $url;    

    public function setUp(): void
    {
        parent::setUp();

        $this->url = '/api/employees';
    }

    public function test_employee_must_have_a_position()
    {
        $position = $this->model->instance('Position')->create();

        $employee = $this->model->instance('Employee')->override(['position_id' => $position])->create();

        $this->assertEquals($position->name, $employee->position->name);
    }

   
    public function test_employee_must_have_a_department()
    {
        $department = $this->model->instance('Department')->create();

        $employee = $this->model->instance('Employee')->override(['department_id' => $department])->create();

        $this->assertEquals($department->name, $employee->department->name);
    }

    public function test_employee_must_have_a_branch()
    {
        $branch = $this->model->instance('Branch')->create();

        $department = $this->model->instance('Department')->override($branch)->create();

        $employee = $this->model->instance('Employee')->override(['department_id' => $department])->create();

        $this->assertEquals($branch->name, $employee->branch->name);
    }

    public function test_employee_must_return_full_name()
    {
        $employee = $this->model->instance('Employee')->override(['surname' => 'Иванов', 'name' => 'Иван', 'patronymic' => 'Иванович'])->create();

        $this->assertEquals($employee->full_name, 'Иванов И.И.');
    }
}
