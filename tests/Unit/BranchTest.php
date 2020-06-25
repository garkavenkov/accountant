<?php

namespace Tests\Unit;

use Tests\TestCase;
use Tests\ModelHelper;
// use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BranchTest extends TestCase
{
   
    use RefreshDatabase;

    private $url;    

    public function setUp(): void
    {
        parent::setUp();

        $this->url = '/api/branches';
    }

    public function test_model_must_return_url()
    {
        $branch = $this->model->instance('Branch')->create();

        $this->assertEquals("{$this->url}/{$branch->id}", $branch->path());
    }

    public function test_branch_may_have_departments()
    {
        $branch = $this->model->instance('Branch')->create();

        $this->model->instance('Department')->override(['branch_id'=> $branch->id])->create(5);

        $this->assertCount(5, $branch->departments);
    }

    public function test_branch_may_have_employees()
    {
        $branch = $this->model->instance('Branch')->create();        

        $department = $this->model->instance('Department')->override(['branch_id'=> $branch])->create();
  
        $empl = $this->model->instance('Employee')->override(['department_id' => $department])->create(5);
        
        $this->assertCount(5, $branch->employees);
    }
}
