<?php

namespace Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ExpenseItemTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
                
        $this->url = '/api/expense-items';        
    }

    public function test_api_should_return_expense_items()
    {
        $type = $this->model->instance('ExpenseProfitItemType')->override(['code' => 'expense'])->create();
        $items = $this->model->instance('ExpenseItem')->override(['type_id' => $type->id])->create(5);
        
        $response = $this->get($this->url, $this->httpHeaders)->getData();
        
        $this->assertCount(5, $response->data);
    }
}

