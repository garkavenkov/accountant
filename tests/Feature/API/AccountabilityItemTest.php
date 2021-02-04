<?php

namespace Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AccountabilityItemTest extends TestCase
{
    use RefreshDatabase;

    private $operation;    

    public function setUp(): void
    {
        parent::setUp();
              
        $this->withoutExceptionHandling();

        $this->url = '/api/accountability-items';
        
        $this->operation = $this->model->instance('CashOperation')->override(['code' => 'accountability'])->create();
    }

    public function test_api_should_create_an_item()
    {
        $accountability = $this->model
                            ->instance('Accountability')
                            ->override(['operation_id' => $this->operation->id])
                            ->create();

        $accountability_type = $this->model
                                    ->instance('AccountabilityItemType')
                                    ->override(['code' => 'income'])
                                    ->create();

        $document_type  =  $this->model
                                ->instance('DocumentType')
                                ->override(['code' => 'income'])
                                ->create();

        $income_document = $this->model
                                ->instance('IncomeDocument')
                                ->override(['document_type_id' => $document_type->id])
                                ->create();

        $item = [
            'cash_document_id'  =>  $accountability->id,
            'type'              =>  $accountability_type->code,
            'owner_id'          =>  $income_document->id,
            'amount'            =>  $income_document->sum1,
        ];
        
        $response = $this->post($this->url, $item, $this->httpHeaders)->assertStatus(201);
        
        $this->assertDatabaseHas('accountability_items', [
            'cash_document_id'  =>  $item['cash_document_id'],
            'owner_id'          =>  $item['owner_id'],
        ]);
    }
}
