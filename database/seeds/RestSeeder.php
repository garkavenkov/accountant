<?php

use App\Models\Cash;
use App\Models\Rest;
use App\Models\RestType;
use App\Models\Department;
use Illuminate\Database\Seeder;

class RestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('rests')->truncate();
    
        $departments = Department::goods()->get();

        $rest_type = RestType::whereCode('department')->get()->first();
        
        foreach ($departments as $department) {
            Rest::create([
                'date'          =>  "2020-10-31",
                'rest_type_id'  =>  $rest_type->id,
                'owner_id'      =>  $department->id,
                'rest'          =>  100000
            ]);
        }    
                
        $cashes = Cash::all();
        $rest_type = RestType::whereCode('cash')->get()->first();

        foreach ($cashes as $cash) {
            Rest::create([
                'date'          =>  "2020-10-31",
                'rest_type_id'  =>  $rest_type->id,
                'owner_id'      =>  $cash->id,
                'rest'          =>  20000
            ]);
        }

    }
}
