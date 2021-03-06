<?php

use Carbon\Carbon;
use App\Models\Document;
use App\Models\Department;
use Faker\Factory as Faker;
use App\Models\DocumentType;
use Illuminate\Database\Seeder;

class MarkupDocumentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('ru_RU');  

        Document::markdown()->delete();
        
        $document_type = DocumentType::where('code', 'markup')->first();
        
        $departments =  Department::goods()->get();
        
        $startDate  = Carbon::createFromFormat('Y-m-d','2020-11-01');
        $endDate    = Carbon::createFromFormat('Y-m-d','2020-11-30');
    
                
        for ($i=0; $i < 50; $i++) { 

            $dep       =   $faker->randomElement($departments);
            
            $employee  =   $dep->employees[0];
            
            
            $sum = $faker->numberBetween($min=10, $max=200);
            
            $date = $faker->dateTimeBetween($startDate, $endDate, $timezome='Europe/Moscow')->format("Y-m-d");
            
            DB::table('documents')->insert([
                'date'                  =>  $date,
                'document_type_id'      =>  $document_type->id,
                'number'                =>  $i+1,                
                'credit_id'             =>  $dep->id,
                'credit_person_id'      =>  $employee->id,
                'debet_id'              =>  0,
                'sum1'                  =>  0,
                'sum2'                  =>  $sum,
                'user_id'               =>  1
            ]);
        }
    }
}
