<?php

namespace Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IncomeDocumentItemTest extends TestCase
{
    use RefreshDatabase;

    private $url;    

    public function setUp(): void
    {
        parent::setUp();
                
        $this->url = '/api/document-items';
    }

    public function test_api_should_create_an_item()
    {
        $document = $this->model->instance('IncomeDocument')->create();

        $item = $this->model->instance('DocumentItem')->override(['document_id' => $document->id])->makeArray();

        $response = $this->post($this->url, $item, $this->httpHeaders)->assertStatus(201);

        $this->assertDatabaseHas('document_items', $item);
    }

    public function test_api_should_delete_an_item()
    {   
        // $document = $this->model->instance('IncomeDocument')->create();

        $item = $this->model->instance('DocumentItem')->create();

        $response = $this->delete($item->path(), [], $this->httpHeaders)->assertStatus(204);

        $this->assertDatabaseMissing('document_items', $item->toArray());
    }

    public function test_api_should_return_an_error_if_name_is_empty()
    {
        $item = $this->model->instance('DocumentItem')->override(['name' => ''])->makeArray();

        $this->post($this->url, $item, $this->httpHeaders)->assertSessionHasErrors('name');

    }

    public function test_api_should_return_an_error_if_quantity_is_zero_or_less()
    {
        $item = $this->model->instance('DocumentItem')->override(['quantity' => 0])->makeArray();

        $this->post($this->url, $item, $this->httpHeaders)->assertSessionHasErrors('quantity');
    }

    public function test_api_should_return_an_error_if_measure_does_not_exist()
    {
        $item = $this->model->instance('DocumentItem')->override(['measure_id' => null])->makeArray();

        $this->post($this->url, $item, $this->httpHeaders)->assertSessionHasErrors('measure_id');
    }

    public function test_api_should_return_an_error_if_price_is_less_or_equals_zero()
    {
        $item = $this->model->instance('DocumentItem')->override(['price' => 0])->makeArray();

        $this->post($this->url, $item, $this->httpHeaders)->assertSessionHasErrors('price');
    }

    public function test_api_should_return_an_error_if_price2_is_less_or_equals_zero()
    {
        $item = $this->model->instance('DocumentItem')->override(['price2' => 0])->makeArray();

        $this->post($this->url, $item, $this->httpHeaders)->assertSessionHasErrors('price2');
    }

    public function test_api_should_return_document_item()
    {
        $item = $this->model->instance('DocumentItem')->create();
        // dd($item);
        $response = $this->get($item->path(), $this->httpHeaders)->getData();
        // dd($response);
        $this->assertEquals($item->name, $response->data->name);
    }

    public function test_api_should_update_an_item()
    {
        $item = $this->model->instance('DocumentItem')->override(['price2' => 80])->create();
      
        $attr['price2'] =  100;
        
        $this->patch($item->path(), $attr, $this->httpHeaders)->assertStatus(201);

        $response = $this->get($item->path(), $this->httpHeaders)->getData();
        
        $this->assertEquals($response->data->price2, $attr['price2']);
    }
}
