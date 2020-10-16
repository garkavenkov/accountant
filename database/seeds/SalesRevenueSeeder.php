<?php

use Carbon\Carbon;
use App\Models\Cash;
use App\Models\Department;
use Faker\Factory as Faker;
use App\Models\SalesRevenue;
use App\Models\CashOperation;
use Illuminate\Database\Seeder;

class SalesRevenueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('ru_RU');  

        SalesRevenue::truncate();

        $departments =  Department::sales()->get();
        
        $cashes = Cash::get();

        $operation_id = CashOperation::where('code', 'sales_revenue')->first()->id;

        for ($i=0; $i < 100; $i++) { 

            $department =   $faker->randomElement($departments);
            
            $date = $faker->dateTimeBetween($startDate = '-2 months', $endDate = '+1 month', $timezome='Europe/Moscow');
            
            $sum = $faker->numberBetween($min=1000, $max=10000);
            
            DB::table('cash_documents')->insert([
                'operation_id'          =>  $operation_id,
                'date'                  =>  $date,
                'number'                =>  $i+1,
                'debet_id'              =>  $department->id,
                'credit_id'             =>  $department->branch->cash->id,                
                'credit'                =>  $sum,
                'user_id'               =>  1
            ]);
            
        }
    
    }
}
