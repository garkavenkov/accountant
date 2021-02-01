<?php

use Illuminate\Database\Seeder;

class CashOperationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cash_operation_types')->truncate();

        DB::table('cash_operation_types')->insert([
            [
                'code' =>  'debet',
                'name' =>  'Дебетовая операция'
            ],
            [
                'code' =>  'credit',
                'name' =>  'Кредитовая операция'
            ],
        ]);
    }
}
