<?php

namespace Tests\Unit;

use Tests\TestCase;

class CashTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->url = '/api/cashes';
    }

    public function test_cash_must_have_a_branch(Type $var = null)
    {
        $branch = $this->model->instance('Branch')->create();

        $cash = $this->model->instance('Cash')->override($branch)->create();

        $this->assertEquals($cash->branch->name, $branch->name);
    }
}
