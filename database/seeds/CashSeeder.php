<?php

use App\Models\Branch;
use Illuminate\Database\Seeder;

class CashSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cashes')->truncate();

        DB::table('cashes')->insert([
            [
                'branch_id' =>  Branch::find(1)->id,
                'name'      =>  'Касс подразделения №1'
            ],
            [
                'branch_id' =>  Branch::find(2)->id,
                'name'      =>  'Касс подразделения №2'
            ],
        ]);
    }
}
