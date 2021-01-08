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
                'code'      =>  'credit',
                'name'      =>  'Получение кредита'
            ],
            [
                'code'      =>  'loan',
                'name'      =>  'Выдача в долг'
            ],
            [
                'code'      =>  'credit_repayment',
                'name'      =>  'Погашение кредита'
            ],
            [
                'code'      =>  'loan_repayment',
                'name'      =>  'Погашение долга'
            ],
            [
                'code'      =>  'expense',
                'name'      =>  'Расход кассы'
            ],
        ]);
    }
}
