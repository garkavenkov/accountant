<?php

use Carbon\Carbon;
use App\Models\Cash;
use App\Models\Department;
use Faker\Factory as Faker;
use App\Models\CashDocument;
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

        CashDocument::salesrevenues()->delete();

        $departments =  Department::sales()->get();

        $operation_id = CashOperation::where('code', 'sales_revenue')->first()->id;

        $enough = false;
        $purpose = 'Сдача торговой выручки';

        $date       = Carbon::createFromFormat("Y-m-d", "2020-10-31");
        $dateEnd    = Carbon::createFromFormat("Y-m-d", "2020-11-30");
        
        while (!$enough) {
            
            $date = $date->addDay();
            $number = 1;

            foreach ($departments as $department) {
                
                $count = $faker->numberBetween($min = 2, $max = 5);

                for ($i = 0; $i< $count; $i++) {
                    $sum = $faker->numberBetween($min=1000, $max=10000);

                    DB::table('cash_documents')->insert([
                        'operation_id'          =>  $operation_id,
                        'date'                  =>  $date->toDateString(),
                        'number'                =>  $number++,
                        'debet_id'              =>  $department->id,
                        'credit_id'             =>  $department->branch->cash->id,                
                        'purpose'               =>  $purpose,
                        'credit'                =>  $sum,
                        'user_id'               =>  1
                    ]);

                }

            }
        
            // echo $date->toDateString() . PHP_EOL;
            $enough = $date->greaterThanOrEqualTo($dateEnd);
        
        }      
    
    }
}
