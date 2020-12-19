<?php

namespace Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShiftTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
                
        $this->url = '/api/shifts';
    }

    public function test_api_should_return_shifts()
    {
        $this->model->instance('Shift')->create(5);

        $response = $this->get($this->url, $this->httpHeaders)->getData();
        
        $this->assertCount(5, $response->data);
    }

    public function test_api_should_return_a_shift()
    {
        $shift = $this->model->instance('Shift')->create();
        
        $response = $this->get($this->url, $this->httpHeaders)->getData();
        // dd($response->data);
        $this->assertEquals($response->data[0]->department, $shift->department->name);
    }

    public function test_api_should_create_shift()
    {
        $shift = $this->model->instance("Shift")->makeArray();

        $response = $this->post($this->url, $shift, $this->httpHeaders)->assertStatus(201);

        $this->assertDatabaseHas('shifts', $shift);
    }

    public function test_api_must_return_error_id_department_id_is_null()
    {
        $shift = $this->model->instance("Shift")->override(['department_id' => null])->makeArray();

        $response = $this->post($this->url, $shift, $this->httpHeaders)->assertSessionHasErrors('department_id');

        $shift = $this->model->instance("Shift")->override(['department_id' => 0])->makeArray();

        $response = $this->post($this->url, $shift, $this->httpHeaders)->assertSessionHasErrors('department_id');
    }

    public function test_api_must_return_error_id_department_id_does_not_exists()
    {        
        $shift = $this->model->instance("Shift")->override(['department_id' => 0])->makeArray();

        $response = $this->post($this->url, $shift, $this->httpHeaders)->assertSessionHasErrors('department_id');
    }

    public function test_api_must_return_error_id_date_begin_is_null()
    {
        $shift = $this->model->instance("Shift")->override(['date_begin' => null])->makeArray();

        $response = $this->post($this->url, $shift, $this->httpHeaders)->assertSessionHasErrors('date_begin');
    }

    public function test_api_must_return_error_id_date_begin_is_not_a_date()
    {
        $shift = $this->model->instance("Shift")->override(['date_begin' => '123'])->makeArray();

        $response = $this->post($this->url, $shift, $this->httpHeaders)->assertSessionHasErrors('date_begin');
    }

    public function test_api_must_return_error_id_date_end_is_null()
    {
        $shift = $this->model->instance("Shift")->override(['date_end' => null])->makeArray();

        $response = $this->post($this->url, $shift, $this->httpHeaders)->assertSessionHasErrors('date_end');
    }

    public function test_api_must_return_error_id_date_end_is_not_a_date()
    {
        $shift = $this->model->instance("Shift")->override(['date_end' => '123'])->makeArray();

        $response = $this->post($this->url, $shift, $this->httpHeaders)->assertSessionHasErrors('date_end');
    }

    public function test_api_must_return_error_id_date_end_must_be_greater_or_equal_date_begin()
    {
        $shift = $this->model->instance("Shift")
                            ->override([
                                'date_begin'    => '2020-12-01',
                                'date_end'      => '2020-11-30'
                            ])
                            ->makeArray();

        $response = $this->post($this->url, $shift, $this->httpHeaders)->assertSessionHasErrors('date_end');
    }

    public function test_api_must_delete_a_shift()
    {
        $shift = $this->model->instance("Shift")->create();

        $this->delete($shift->path(), [], $this->httpHeaders)->assertStatus(200);

        $this->assertDatabaseMissing('shifts', [
            'id'    =>  $shift->id
        ]);
    }

    public function test_api_must_add_employee_into_shift()
    {
        $department = $this->model->instance('Department')->override(['name' => 'Department1'])->create();
        
        $employee = $this->model->instance('Employee')->override($department)->create();

        $shift = $this->model->instance('Shift')->override($department)->create();
        
        $data['employee_id']   =  $employee->id;
        $data['shift_id']      =  $shift->id;
                
        $url = "/api/add-employee-into-shift";
        
        $response = $this->post($url, $data, $this->httpHeaders)->assertStatus(201);
        
        $this->assertDatabaseHas('shift_employees', [
            'shift_id'      =>  $shift->id,
            'employee_id'   =>  $employee->id
        ]);
    }
    
    public function test_api_must_not_add_employee_if_already_exists_in_shift()
    {
        $department = $this->model->instance('Department')->override(['name' => 'Department1'])->create();
        
        $employee = $this->model->instance('Employee')->override($department)->create();

        $shift = $this->model->instance('Shift')->override($department)->create();
        
        $se = $this->model->instance('ShiftEmployee')
                    ->override([
                        $shift,
                        $employee
                    ])
                    ->create();
        

        $data['employee_id']    =  $employee->id;
        $data['shift_id']       =  $shift->id; 
        
        $url = "/api/add-employee-into-shift";
        
        $response = $this->post($url, $data, $this->httpHeaders)->assertSessionHasErrors('employee_id');;
        
        $this->assertCount(1, $shift->employees);
    }

    public function test_api_should_delete_employee_from_shift()
    {
        $department = $this->model->instance('Department')->override(['name' => 'Department1'])->create();
        
        $employee = $this->model->instance('Employee')->override($department)->create();

        $shift = $this->model->instance('Shift')->override($department)->create();
        
        $se = $this->model->instance('ShiftEmployee')
                    ->override([
                        $shift,
                        $employee
                    ])
                    ->create();
        
        $response = $this->delete("/api/remove-employee-from-shift/{$shift->id}/{$employee->id}", [], $this->httpHeaders)
                        ->assertStatus(200);
        
        $this->assertDatabaseMissing('shift_employees', [
            'shift_id'      =>  $shift->id,
            'employee_id'   =>  $employee->id
        ]);
    }
}
