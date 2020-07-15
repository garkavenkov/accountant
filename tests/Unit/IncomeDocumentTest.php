<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IncomeDocumentTest extends TestCase
{
    use RefreshDatabase;

    private $url;    

    public function setUp(): void
    {
        parent::setUp();

        $this->url = '/api/income-documents';
    }

    public function test_income_document_must_return_a_supplier()
    {
        $supplier = $this->model->instance('Supplier')->create();

        $doc = $this->model->instance('IncomeDocument')->override(['debit_id' => $supplier->id])->create();

        $this->assertEquals($doc->supplier->name, $supplier->name);
    }

    public function test_income_document_must_return_a_department()
    {
        $department = $this->model->instance('Department')->create();

        $doc = $this->model->instance('IncomeDocument')->override(['credit_id' => $department->id])->create();

        $this->assertEquals($doc->department->name, $department->name);
    }

    public function test_income_document_must_return_an_employee()
    {
        $employee = $this->model->instance('Employee')->create();

        $doc = $this->model
                    ->instance('IncomeDocument')
                    ->override([
                        'credit_id'         => $employee->department->id, 
                        'credit_person_id'  => $employee->id
                    ])
                    ->create();

        $this->assertEquals($doc->employee->full_name, $employee->full_name);
    }

    public function test_income_document_should_return_a_url()
    {
        $doc = $this->model->instance('IncomeDocument')->create();

        $this->assertEquals($doc->path(), "{$this->url}/{$doc->id}");
    }

    public function test_income_documents_should_return_items()
    {
        $doc = $this->model->instance('IncomeDocument')->states('items')->create();
        
        $this->assertCount(5, $doc->items);
    }

    public function test_income_document_number_should_automatically_increment()
    {
        $docs = $this->model->instance('IncomeDocument')->create(5);
        
        $this->assertEquals(5, $docs[4]->number);
    }
}
