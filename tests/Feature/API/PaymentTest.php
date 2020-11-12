<?php

namespace Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    // private $url;    

    public function setUp(): void
    {
        parent::setUp();
                
        $this->url = '/api/payments';
        
        $this->operation = $this->model->instance('CashOperation')->override(['code' => 'payment'])->create();
    }

    public function test_api_should_return_payments()
    {
        $this->model->instance('Payment')->override(['operation_id' => $this->operation->id])->create(5);

        $response = $this->get($this->url, $this->httpHeaders)->getData();
        // dd($response);
        $this->assertCount(5, $response->data);
    }

    public function test_api_should_return_payment()
    {
        $payment = $this->model->instance('Payment')->override(['operation_id' => $this->operation->id])->create();

        $response = $this->get($payment->path(), $this->httpHeaders)->getData();
        
        $this->assertEquals($response->data->supplier, $payment->supplier->name);
    }

    public function test_api_should_create_payment()
    {
        $payment = $this->model->instance('Payment')->override(['operation_id' => $this->operation->id])->makeArray();

        $this->post($this->url, $payment, $this->httpHeaders)->assertStatus(201);

        $this->assertDatabaseHas('cash_documents', $payment);
    }

    public function test_api_shold_delete_payment()
    {
        $payment = $this->model->instance('Payment')->override(['operation_id' => $this->operation->id])->create();

        $this->delete($payment->path(),  [] ,$this->httpHeaders)->assertStatus(200);

        $this->assertDatabaseMissing('cash_documents', [
            'id'    =>  $payment->id
        ]);
    }
    

}
