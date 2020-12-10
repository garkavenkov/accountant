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

        $position_id = Position::where('name', 'Продавец')->first()->id;

        $departments =  Department::goods()->get();

        foreach ($departments as $department) {
        
            for ($i=0; $i < 2; $i++) { 
                DB::table('employees')->insert(
                    [
                        'name'              =>  $faker->firstNameFemale,
                        'patronymic'        =>  $faker->middleNameFemale,
                        'surname'           =>  $faker->lastName('female'),
                        'position_id'       =>  $position_id,
                        'department_id'     =>  $department->id,
                        'address'           =>  $faker->address,
                        'birthdate'         =>  $faker->dateTimeBetween($startDate = '-50 years', $endDate = '-20 years', $timezome='Europe/Moscow')->format("Y-m-d"),
                        'hired'             =>  $faker->dateTimeBetween($department->opened, "2020-10-31", $timezome='Europe/Moscow')->format("Y-m-d"),
                        
                    ]
                );
            }            
        }        
    }
}
