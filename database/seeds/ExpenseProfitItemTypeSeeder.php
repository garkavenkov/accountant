<?php

use Illuminate\Database\Seeder;

class ExpenseProfitItemTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('expense_profit_item_types')->truncate();

        DB::table('expense_profit_item_types')->insert([
            [
                'code'          =>  'expense',
                'name'          =>  'Расход кассы',
            ],
            [
                'code'          =>  'profit',
                'name'          =>  'Доход кассы',
            ]
        ]);
    }
}
