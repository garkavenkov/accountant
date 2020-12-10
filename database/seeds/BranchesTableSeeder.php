<?php

use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class BranchesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Faker::create();

        DB::table('branches')->truncate();

        $startDate  = Carbon::createFromFormat('Y-m-d','2020-06-01');
        $endDate    = Carbon::createFromFormat('Y-m-d','2020-09-30');

        DB::table('branches')->insert([
            [
                'name'      =>  "Branch 1",
                'address'   =>  $faker->address,
                'opened'    =>  $faker->dateTimeBetween($startDate, $endDate)->format('Y-m-d'),
                'closed'    =>  null
            ],
            [
                'name'      =>  "Branch 2",
                'address'   =>  $faker->address,
                'opened'    =>  $faker->dateTimeBetween($startDate, $endDate)->format('Y-m-d'),
                'closed'    =>  null
            ],
        ]);
    }
}
