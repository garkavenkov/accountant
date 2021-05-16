<?php

namespace Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoanContractTest extends TestCase
{
    use RefreshDatabase;    

    public function setUp(): void
    {
        parent::setUp();

        $this->withoutExceptionHandling();

        $this->url = '/api/loans';
        $this->contract_type = $this->model->instance('ContractType')->override(['code' => 'loan'])->create();
        $this->model->instance('CashOperation')->override(['code'=> 'loan'])->create();
        $this->linked_document_type = $this->model
                                        ->instance('LinkedDocumentType')
                                        ->override(['code' => 'loan'])
                                        ->create();

    }

    public function test_api_should_return_loans()
    {
        $this->model->instance('LoanContract')->override(['contract_type_id' => $this->contract_type->id])->create(5);

        $response = $this->get($this->url, $this->httpHeaders)->getData();

        $this->assertCount(5, $response->data);
    }

    public function test_api_should_return_single_loan()
    {
        $loan = $this->model->instance('LoanContract')->override(['contract_type_id' => $this->contract_type->id])->create();

        $response = $this->get($loan->path(), $this->httpHeaders)->getData();

        $this->assertEquals($response->data->amount, $loan->amount);
    }

    public function test_api_should_create_loan()
    {
        $currency = $this->model
                        ->instance('Currency')
                        ->override(['code' => 'RUB'])
                        ->create();

        $data    = $this->model
                        ->instance('LoanContract')
                        ->override([
                            'contract_type_id'  => $this->contract_type->id,
                            'currency_id'       => $currency->id,
                            'amount'            => 100000,
                            
                        ])
                        ->makeArray();
        
        $response = $this->post($this->url, $data, $this->httpHeaders)->assertStatus(201);
        
        $loan_contract = $response->getData();
        // dd($loan_contract);

        $this->assertDatabaseHas('contracts', [
            'counterparty_id'   =>  $data['counterparty_id'],
            'currency_id'       =>  $data['currency_id'],
        ]);

        $this->assertDatabaseHas('cash_documents', [
            'date'      =>  $data['date_begin'],
            'debet_id'  =>  $loan_contract->id,
            'credit'    =>  $data['amount'],
        ]);

        $this->assertDatabaseHas('linked_documents', [
            'type_id'           =>  $this->linked_document_type->id,            
            'owner_id'          =>  $loan_contract->id
        ]);

    }

}
