<?php

use Illuminate\Database\Seeder;

class RestTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rest_types')->truncate();

        DB::table('rest_types')->insert([
            [
                'code'          =>  'department',
                'name'          =>  'Отдел',
                'description'   =>  'Остаток товара на отделе'
            ],
            [
                'code'          =>  'cash',
                'name'          =>  'Касса',
                'description'   =>  'Остаток денежных средств в кассе'
            ],
            [
                'code'          =>  'credit',
                'name'          =>  'Кредит',
                'description'   =>  'Задолженность по кредиту'
            ]
        ]);
    }
}
