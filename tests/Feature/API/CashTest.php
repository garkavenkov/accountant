<?php

namespace Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CashTest extends TestCase
{
   public function setUp(): void
   {
       parent::setUp();

       $this->url = '/api/cashes';
   }

   public function test_api_should_return_cashes()
   {
        $this->model->instance('Cash')->create(2);

        $response = $this->get($this->url, $this->httpHeaders)->getData();
        // dd($response);
        $this->assertCount(2, $response->data);
   }

}
