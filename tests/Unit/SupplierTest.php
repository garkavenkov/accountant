<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SupplierTest extends TestCase
{
    use RefreshDatabase;

    // protected $url;    

    public function setUp(): void
    {
        parent::setUp();

        // $this->url = '/api/suppliers';
    }

    public function test_supplier_must_return_unpaid_documents_if_any_exist()
    {
        $supplier = $this->model->instance('Supplier')->create();

        $documents = $this->model->instance('IncomeDocument')->override(['debet_id' => $supplier->id])->create(3);

        $this->assertCount(3, $supplier->unpaid);
        
    }

}
