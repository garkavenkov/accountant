<?php

use Illuminate\Database\Seeder;

class SalaryTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('salary_types')->truncate();

        DB::table('salary_types')->insert([
            [
                'code'          =>  'salary',
                'name'          =>  'Оклад',
                'description'   =>  'Заработная плата за месяц'
            ],
            [
                'code'          =>  'daily',
                'name'          =>  'Поденно',
                'description'   =>  'Поденная оплата труда'
            ],
            [
                'code'          =>  'percent',
                'name'          =>  'Процент',
                'description'   =>  'Процент от торгвой выручки'
            ],
        ]);
    }
}
