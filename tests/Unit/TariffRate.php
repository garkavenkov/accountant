<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TariffRate extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_tariff_rate_must_have_a_salary_type()
    {
        $salary_type = $this->model->instance('SalaryType')->override(['code' => 'dayly'])->create();

        $tariff = $this->model->instance('TariffRate')->override(['salary_type_id' => $salary_type->id])->create();
        
        $this->assertEquals($tariff->salary->code, $salary_type->code);
    }
}
