<?php

use Illuminate\Database\Seeder;

class ContractTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contract_types')->truncate();

        DB::table('contract_types')->insert([
            [
                'code'  =>  'loan',
                'name'  =>  'Ссуда',
                'created_at'    =>  date('Y-m-d H:i:s'),
                'updated_at'    =>  date('Y-m-d H:i:s')
            ],
            [
                'code'  =>  'lend',
                'name'  =>  'Давать в долг',
                'created_at'    =>  date('Y-m-d H:i:s'),
                'updated_at'    =>  date('Y-m-d H:i:s')
            ],
        ]);   
    }
}
