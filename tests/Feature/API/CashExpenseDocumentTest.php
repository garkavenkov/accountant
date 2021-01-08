<?php

namespace Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CashExpenseDocumentTest extends TestCase
{
    use RefreshDatabase;

    private $operation;    

    public function setUp(): void
    {
        parent::setUp();
                
        $this->url = '/api/cash-expense-documents';
        
        $this->operation = $this->model->instance('CashOperation')->override(['code' => 'expense'])->create();
        $this->type = $this->model->instance('ExpenseProfitItemType')->override(['code' => 'expense'])->create();
    }

    public function test_api_should_return_cash_expense_documents()
    {
        $expense = $this->model->instance('ExpenseItem')->override(['type_id' => $this->type->id])->create();
        $this->model->instance('CashExpenseDocument')->override(['credit_id' => $expense->id])->create(5);

        $response = $this->get($this->url, $this->httpHeaders)->getData();
        
        $this->assertCount(5, $response->data);
    }

    public function test_api_should_return_single_cash_expense_document()
    {
        $expense = $this->model->instance('ExpenseItem')->override(['type_id' => $this->type->id])->create();
        $doc = $this->model->instance('CashExpenseDocument')->override(['credit_id' => $expense->id])->create();

        $response = $this->get($doc->path(), $this->httpHeaders)->getData();
        
        $this->assertEquals($response->data->amount, $doc->debet);
    }

    public function test_api_should_delete_document()
    {
        $doc = $this->model->instance('CashExpenseDocument')->create();

        $response = $this->delete($doc->path(), [], $this->httpHeaders)->assertStatus(200);

        $this->assertDatabaseMissing('cash_documents', ['id' => $doc->id] );
    }
}
