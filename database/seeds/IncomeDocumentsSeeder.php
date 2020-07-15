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
        
                
        for ($i=0; $i < 20; $i++) { 

            $department =   $faker->randomElement($departments);
            $supplier   =   $faker->randomElement($suppliers);
            $employee   =   $department->employees[0];
            
            
            $sum = $faker->numberBetween($min=1000, $max=10000);

            DB::table('documents')->insert([
                'date'                  =>  Carbon::now()->isoFormat('YYYY-MM-DD'),
                'number'                =>  $i+1,
                'debit_id'              =>  $supplier->id,
                'credit_id'             =>  $department->id,
                'credit_person_id'      =>  $employee->id,
                'sum1'                  =>  $sum,
                'sum2'                  =>  $sum * 1.2,
                'user_id'               =>  1
            ]);
        }
    }
}
