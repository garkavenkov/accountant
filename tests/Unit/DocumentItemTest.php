<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DocumentItemTest extends TestCase
{
    use RefreshDatabase;

    private $url;    

    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_item_must_have_measure()
    {
        $measure = $this->model->instance('Measure')->create();
        $item = $this->model->instance('DocumentItem')->override($measure)->create();

        $this->assertEquals($item->measure->name, $measure->name);
    }

}
