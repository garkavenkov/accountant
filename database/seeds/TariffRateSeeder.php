<?php

use App\Models\Employee;
use App\Models\SalaryType;
use App\Models\TariffRate;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class TariffRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tariff_rates')->truncate();

        $faker = Faker::create('ru_RU');

        $employees = Employee::get();
        $slary_types = SalaryType::get();
        
        foreach ($employees as $employee) {
            
            $salary_type = $faker->randomElement($slary_types);

            switch ($salary_type->code) {
                case 'salary':
                    $amount     = $faker->randomElement([5000, 8000, 10000, 15000]);
                    $amount2    = $amount + 2000;
                    break;
                case 'daily':
                    $amount = $faker->randomElement([350, 400, 500]);
                    $amount2    = $amount + 100;
                    break;
                case 'percent':
                    $amount = $faker->randomElement([3, 4, 5]);
                    $amount2    = $amount + 1;
                    break;                    
                default:
                    $amount = 1000;
                    break;
            }

            TariffRate::create([
                'date'              =>  $employee->hired,
                'employee_id'       =>  $employee->id,
                'salary_type_id'    =>  $salary_type->id,
                'amount'            =>  $amount
            ]);

            if ($faker->randomDigit() >= 5) {
                $date = Carbon\Carbon::createFromFormat('Y-m-d', $employee->hired)->endOfYear()->addDay()->format('Y-m-d');
                TariffRate::create([
                    'date'              =>  $date,
                    'employee_id'       =>  $employee->id,
                    'salary_type_id'    =>  $salary_type->id,
                    'amount'            =>  $amount2
                ]); 
            }


        }
    }
}
