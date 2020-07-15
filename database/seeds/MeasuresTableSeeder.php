<?php

use Illuminate\Database\Seeder;

class MeasuresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('measures')->truncate();
        
        DB::table('measures')->insert([
            [
                'name'          =>  'шт.',
                'full_name'     =>  'Штука'
            ],
            [
                'name'          =>  'кг.',
                'full_name'     =>  'Килограмм'
            ]            
        ]);
    }
}
