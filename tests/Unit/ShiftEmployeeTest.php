<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShiftEmployeeTest extends TestCase
{
    use RefreshDatabase;

    // private $url;    

    public function setUp(): void
    {
        parent::setUp();

        // $this->url = '/api/shifts';
    }  
    
    public function test_api_should_not_add_employee_into_shift_if_already_added()
    {
        $department = $this->model->instance('Department')->override(['name' => 'Department1'])->create();
        
        $employee = $this->model->instance('Employee')->override($department)->create();

        $shift = $this->model->instance('Shift')->override($department)->create();

        $this->model->instance('ShiftEmployee')
                    ->override([
                        'shift_id'      =>  $shift->id,
                        'employee_id'   =>  $employee->id
                    ])
                    ->create();
        
        // dd($shift->employees);

        $this->model->instance('ShiftEmployee')
                    ->override([
                        'shift_id'      =>  $shift->id,
                        'employee_id'   =>  $employee->id
                    ])
                    ->create();

        
        // ShiftEmployee::get()->count()
    }
}
