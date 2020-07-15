<?php

use Illuminate\Database\Seeder;

class DepartmentTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('department_types')->truncate();

        DB::table('department_types')->insert([
            [
                'code'          =>  'administration',
                'name'          =>  'Администрация предприятия',
                'description'   =>  'Администрация предприятия'
            ],
            [
                'code'          =>  'outlet',
                'name'          =>  'Торговая точка',
                'description'   =>  'Торговая точка'
            ],
            [
                'code'          =>  'household',
                'name'          =>  'Хозяйственный отдел',
                'description'   =>  'Хозяйственный отдел'
            ],
            [
                'code'          =>  'stock',
                'name'          =>  'Склад',
                'description'   =>  'Склад'
            ],
            [
                'code'          =>  'production',
                'name'          =>  'Производственная точка',
                'description'   =>  'Производственная точка'
            ],
        ]);
    }
}
