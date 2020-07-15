<?php

use Illuminate\Database\Seeder;

class PositionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('positions')->truncate();
        
        DB::table('positions')->insert([
            [
                'name'          =>  'Директор',
                'description'   =>  'Директор предприятия'
            ],
            [
                'name'          =>  'Гл. бухгалтер',
                'description'   =>  'Главный бухгалтер предприятия'
            ],
            [
                'name'          =>  'Товаровед',
                'description'   =>  'Товаровед предприятия'
            ],
            [
                'name'          =>  'Продавец',
                'description'   =>  'Продавец на отделе'
            ],
            [
                'name'          =>  'Грузчик',
                'description'   =>  'Грузчик'
            ],
            [
                'name'          =>  'Повар',
                'description'   =>  'Повар'
            ]
        ]);
    }
}
