<?php

use Carbon\Carbon;
use App\Models\Supplier;
use App\Models\Department;
use Faker\Factory as Faker;
use App\Models\IncomeDocument;
use Illuminate\Database\Seeder;

class IncomeDocumentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('ru_RU');  

        DB::table('documents')->truncate();

        $departments =  Department::goods()->get();
        $suppliers   =  Supplier::get();
        
        $startDate  = Carbon::createFromFormat('Y-m-d','2020-11-01');
        $endDate    = Carbon::createFromFormat('Y-m-d','2020-11-30');
    
                
        for ($i=0; $i < 100; $i++) { 

            $department =   $faker->randomElement($departments);
            $supplier   =   $faker->randomElement($suppliers);
            $employee   =   $department->employees[0];            
            
            $sum = $faker->numberBetween($min=1000, $max=10000);
            
            $date = $faker->dateTimeBetween($startDate, $endDate, $timezome='Europe/Moscow')->format("Y-m-d");
            
            DB::table('documents')->insert([
                'date'                  =>  $date,
                'number'                =>  $i+1,
                'debet_id'              =>  $supplier->id,
                'credit_id'             =>  $department->id,
                'credit_person_id'      =>  $employee->id,
                'sum1'                  =>  $sum,
                'sum2'                  =>  $sum * 1.2,
                'user_id'               =>  1
            ]);
        }
    }
}
