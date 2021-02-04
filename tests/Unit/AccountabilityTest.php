<?php

namespace Tests\Unit;

use Tests\TestCase;

class AccountabilityTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->url = '/api/acountabilities';
        
        $this->operation = $this->model->instance('CashOperation')->override(['code' => 'accountability'])->create();
        $this->document_type    = $this->model->instance('DocumentType')->override(['code' => 'income'])->create();
    }

    public function test_accountability_may_have_items()
    {
        $doc = $this->model->instance('Accountability')->override(['operation_id' => $this->operation->id])->create();

        $item = $this->model->instance('AccountabilityItem')->override(['cash_document_id' => $doc->id])->create(5);

        $this->assertCount(5, $doc->items);
    }
}
