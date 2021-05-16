<?php

namespace Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CounterpartyTest extends TestCase
{
    use RefreshDatabase;    

    public function setUp(): void
    {
        parent::setUp();

        $this->withoutExceptionHandling();

        $this->url = '/api/counterparties';
    }

    public function test_api_should_return_counterparties()
    {
        $this->model->instance('Counterparty')->create(5);

        $response = $this->get($this->url, $this->httpHeaders)->getData();

        $this->assertCount(5, $response->data);
    }

    public function test_api_should_return_a_single_counterparty()
    {
        $counterparty = $this->model
                            ->instance('Counterparty')
                            ->override(['name'  =>  'John'])
                            ->create();
        
        $response = $this->get($counterparty->path(), $this->httpHeaders)->getData();
        
        $this->assertEquals($response->data->name, $counterparty['name']);
    }
}
