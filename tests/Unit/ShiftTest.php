<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShiftTest extends TestCase
{
    use RefreshDatabase;

    private $url;    

    public function setUp(): void
    {
        parent::setUp();

        $this->url = '/api/shifts';
    }

    public function test_shift_must_have_a_department()
    {
        $department = $this->model->instance('Department')->create();

        $shift = $this->model->instance('Shift')->override($department)->create();

        $this->assertEquals($shift->department->name, $department->name);
    }

    public function test_shift_must_have_an_employee()
    {   
        $department = $this->model->instance('Department')->create();

        $shift = $this->model->instance('Shift')->states('employees')->override($department)->create();
        
        $this->assertCount(1, $shift->employees);
    }
    
}
