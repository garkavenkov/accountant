<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmployeeTest extends TestCase
{
    use RefreshDatabase;

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

    public function test_employee_may_have_tariff_rates()
    {
        $employee = $this->model->instance('Employee')->create();

        $salary_type = $this->model->instance('SalaryType')->override(['code' => 'salary'])->create();
        
        $tariff_rates = $this->model
                            ->instance('TariffRate')
                            ->override([
                                'employee_id'       =>  $employee->id,
                                'salary_type_id'    =>  $salary_type->id,            
                            ])
                            ->create(2);
      
        $this->assertCount(2, $employee->tariffRates);

    }

    public function test_employee_may_have_current_salary()
    {
        $employee = $this->model->instance('Employee')->create();

        $salary_type = $this->model->instance('SalaryType')->override(['code' => 'salary'])->create();

        $this->model->instance('TariffRate')
                    ->override([
                        'date'              =>  "2020-01-01",
                        'employee_id'       =>  $employee->id,
                        'salary_type_id'    =>  $salary_type->id,
                        'amount'            =>  10000
                    ])
                    ->create();

        

        $this->model->instance('TariffRate')
                    ->override([
                        'date'              =>  "2021-01-01",
                        'employee_id'       =>  $employee->id,
                        'salary_type_id'    =>  $salary_type->id,
                        'amount'            =>  20000
                    ])
                    ->create();
        // dd($employee->salary()->amount);
        $this->assertEquals($employee->salary()->amount, 10000);
        $this->assertEquals($employee->salary("2021-01-01")->amount, 20000);
        $this->assertNull($employee->salary("2019-12-31"));
    }

    public function test_employee_may_have_shift()
    {
        $employee = $this->model->instance('Employee')->create();

        $shift = $this->model->instance('Shift')
                            ->override([
                                'department_id' =>  $employee->department_id,
                                'date_begin'    =>  "2020-11-02",
                                'date_end'      =>  "2020-11-15",
                            ])
                            ->create();

        $this->model->instance('ShiftEmployee')
                    ->override([
                        'shift_id'      =>  $shift->id,
                        'employee_id'   =>  $employee->id
                    ])->create();
        
        $shift = $this->model->instance('Shift')
                            ->override([
                                'department_id' =>  $employee->department_id,
                                'date_begin'    =>  "2020-11-16",
                                'date_end'      =>  "2020-11-29",
                            ])
                            ->create();

        $this->model->instance('ShiftEmployee')
                            ->override([
                                'shift_id'      =>  $shift->id,
                                'employee_id'   =>  $employee->id
                            ])
                            ->create();

        $this->assertCount(2, $employee->shifts);
    }    

}
