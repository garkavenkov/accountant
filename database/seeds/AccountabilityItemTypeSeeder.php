<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class AccountabilityItemTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        DB::table('accountability_item_types')->truncate();        

        DB::table('accountability_item_types')->insert([
            [
                'code'          =>  'income',
                'name'          =>  'Товарная накладная',
                'created_at'    =>  date('Y-m-d H:i:s'),
                'updated_at'    =>  date('Y-m-d H:i:s')
            ],
            [
                'code'          =>  'expense',
                'name'          =>  'Расход кассы',
                'created_at'    =>  date('Y-m-d H:i:s'),
                'updated_at'    =>  date('Y-m-d H:i:s')
            ],
            [
                'code'          =>  'return',
                'name'          =>  'Возврат денег в кассу',
                'created_at'    =>  date('Y-m-d H:i:s'),
                'updated_at'    =>  date('Y-m-d H:i:s')
            ],
        ]);
    }
}
