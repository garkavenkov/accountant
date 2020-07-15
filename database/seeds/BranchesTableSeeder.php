<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

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

        DB::table('branches')->insert([
            [
                'name'      =>  "Branch 1",
                'address'   =>  $faker->address,
                'opened'    =>  $faker->dateTimeBetween($startDate = "-1 year", $endDate = "-1 month"),
                'closed'    =>  null
            ],
            [
                'name'      =>  "Branch 2",
                'address'   =>  $faker->address,
                'opened'    =>  $faker->dateTimeBetween($startDate = "-11 months", $endDate = "-1 month"),
                'closed'    =>  null
            ],
        ]);
    }
}
