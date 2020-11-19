<?php

use Carbon\Carbon;
use App\Models\Document;
use App\Models\Department;
use Faker\Factory as Faker;
use App\Models\DocumentType;
use Illuminate\Database\Seeder;
use App\Models\TransferDocument;

class TransferDocumentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('ru_RU');  

        Document::transfer()->delete();
        
        $document_type = DocumentType::where('code', 'transfer')->first();
        
        $departments =  Department::goods()->get();
        
        $startDate  = Carbon::createFromFormat('Y-m-d','2020-11-01');
        $endDate    = Carbon::createFromFormat('Y-m-d','2020-11-30');
    
                
        for ($i=0; $i < 100; $i++) { 

            $deps       =   $faker->randomElements($departments, $count=2);
            
            $employee_gives   =   $deps[0]->employees[0];
            $employee_takes   =   $deps[1]->employees[0];
            
            $sum = $faker->numberBetween($min=1000, $max=10000);
            
            $date = $faker->dateTimeBetween($startDate, $endDate, $timezome='Europe/Moscow')->format("Y-m-d");
            
            DB::table('documents')->insert([
                'date'                  =>  $date,
                'document_type_id'      =>  $document_type->id,
                'number'                =>  $i+1,
                'debet_id'              =>  $deps[0]->id,
                'debet_person_id'       =>  $employee_gives->id,
                'credit_id'             =>  $deps[1]->id,
                'credit_person_id'      =>  $employee_takes->id,
                'sum1'                  =>  $sum,
                'sum2'                  =>  $sum,
                'user_id'               =>  1
            ]);
        }
    }
}
