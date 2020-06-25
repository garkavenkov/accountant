<?php

use App\Models\Branch;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Faker::create();

        DB::table('departments')->delete();

        $branch = Branch::whereName('Branch 1')->get()->first();
        DB::table('departments')->insert([
            [
                'branch_id'     =>  $branch->id,
                'name'          =>  "Department 1",
                'description'   =>  $faker->sentence(6),
                'opened'        =>  $faker->dateTimeBetween($startDate = $branch->opened, $endDate='-1 month')                
            ],
            [
                'branch_id'     =>  $branch->id,
                'name'          =>  "Department 2",
                'description'   =>  $faker->sentence(6),
                'opened'        =>  $faker->dateTimeBetween($startDate = $branch->opened, $endDate='-1 month')                
            ],
            [
                'branch_id'     =>  $branch->id,
                'name'          =>  "Department 3",
                'description'   =>  $faker->sentence(6),
                'opened'        =>  $faker->dateTimeBetween($startDate = $branch->opened, $endDate='-1 month')                
            ],
        ]);


        $branch = Branch::whereName('Branch 2')->get()->first();
        DB::table('departments')->insert([
            [
                'branch_id'     =>  $branch->id,
                'name'          =>  "Department 1",
                'description'   =>  $faker->sentence(6),
                'opened'        =>  $faker->dateTimeBetween($startDate = $branch->opened, $endDate='-1 month')                
            ],
            [
                'branch_id'     =>  $branch->id,
                'name'          =>  "Department 2",
                'description'   =>  $faker->sentence(6),
                'opened'        =>  $faker->dateTimeBetween($startDate = $branch->opened, $endDate='-1 month')                
            ],
        ]);
        

    }
}
