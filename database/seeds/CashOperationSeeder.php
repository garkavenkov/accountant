<?php

use Illuminate\Database\Seeder;

class CashOperationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cash_operations')->truncate();

        DB::table('cash_operations')->insert([
            [
                'code'      =>  'payment',
                'name'      =>  'Оплата за товар'
            ],
            [
                'code'      =>  'sales_revenue',
                'name'      =>  'Торговая выручка'
            ],
            [
                'code'      =>  'salary',
                'name'      =>  'Заработная плата'
            ],
            [
                'code'      =>  'loan',
                'name'      =>  'Получение кредита'
            ],
            [
                'code'      =>  'lend',
                'name'      =>  'Выдача в долг'
            ],
            [
                'code'      =>  'loan_repayment',
                'name'      =>  'Погашение кредита'
            ],
            [
                'code'      =>  'lend_repayment',
                'name'      =>  'Погашение долга'
            ],
            [
                'code'      =>  'expense',
                'name'      =>  'Расход кассы'
            ],
        ]);
    }
}
