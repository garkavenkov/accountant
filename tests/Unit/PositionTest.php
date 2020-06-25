<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PositionTest extends TestCase
{
    use RefreshDatabase;

    private $url;    

    public function setUp(): void
    {
        parent::setUp();

        $this->url = '/api/positions';
    }

    public function test_position_may_have_many_employees()
    {
        $position = $this->model->instance('Position')->create();

        $this->model->instance('Employee')->override(['position_id' => $position])->create(5);

        $this->assertCount(5, $position->employees);
    }
}
