<?php

namespace Tests\Unit;

use Tests\TestCase;

class SalesRevenue extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_document_must_have_a_department()
    {
        $department = $this->model->instance('Department')->create();
        
        $document = $this->model->instance('SalesRevenue')->override(['debet_id' => $department->id])->create();
        
        $this->assertEquals($document->department->name, $department->name);
    }

    public function test_document_must_have_a_cash()
    {
        $cash = $this->model->instance('Cash')->create();
        
        $document = $this->model->instance('SalesRevenue')->override(['credit_id' => $cash->id])->create();
        
        $this->assertEquals($document->cash->name, $cash->name);
    }

}
