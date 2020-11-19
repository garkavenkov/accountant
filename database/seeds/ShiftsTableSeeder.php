<?php

use Carbon\Carbon;
use App\Models\Shift;
use App\Models\Department;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class ShiftsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shifts')->truncate();

        $faker = Faker::create('ru_RU');  

        $departments = Department::goods()->get();

        foreach ($departments as $department) {
            
            $dateBegin = Carbon::createFromFormat('Y-m-d','2020-11-01')->toDateString();
            
            foreach ($department->employees as $employee) {
            
                $dateEnd    = Carbon::parse($dateBegin)->addWeeks(2)->toDateString();

                $shift_id = DB::table('shifts')->insertGetId([
                    'department_id' =>  $department->id,
                    'date_begin'    =>  $dateBegin,
                    'date_end'      =>  $dateEnd
                ]);

                DB::table('shift_employees')->insert([
                    'shift_id'      =>  $shift_id,
                    'employee_id'   =>  $employee->id,                    
                ]);

                $dateBegin = Carbon::parse($dateEnd)->addDays(1)->toDateString();
            }            
            
        }
    }
}
