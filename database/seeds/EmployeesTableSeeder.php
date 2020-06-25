<?php

use App\Models\Position;
use App\Models\Department;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('ru_RU');

        DB::table('employees')->truncate();
        
        $positions      = Position::get();        
        $departments    = Department::get();
        
        for ($i=0; $i < 20; $i++) { 
            $position   =  $faker->numberBetween(0, count($positions)-1);
            $department =  $faker->numberBetween(0, count($departments)-1);

            DB::table('employees')->insert([
                [
                    'name'              =>  $faker->firstNameMale,
                    'patronymic'        =>  $faker->middleNameMale,
                    'surname'           =>  $faker->lastName('male'),
                    'birthdate'         =>  $faker->dateTimeBetween($startDate = '-50 years', $endDate = '-20 years'),
                    'address'           =>  $faker->address,  
                    'department_id'     =>  $departments[$department]->id,
                    'position_id'       =>  $positions[$position]->id,
                    'hired'             =>  $faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now'),
                    // 'fired'             =>
                ]
            ]);

        }
    }
}
