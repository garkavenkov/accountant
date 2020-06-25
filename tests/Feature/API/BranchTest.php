<?php

namespace Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BranchTest extends TestCase
{
    use RefreshDatabase;

    private $url;    

    public function setUp(): void
    {
        parent::setUp();
                
        $this->url = '/api/branches';
    }

    public function test_api_should_return_branches()
    {
        $this->model->instance('Branch')->create(5);

        $response = $this->get($this->url, $this->httpHeaders)->getData();
        
        $this->assertCount(5, $response);
    }

    public function test_api_should_return_a_branch()
    {
        $branch = $this->model->instance('Branch')->create();

        $response = $this->get($branch->path(), $this->httpHeaders)->getData();
        
        $this->assertEquals($branch->name, $response->name);
    }
    
}
