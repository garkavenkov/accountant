<?php

use Carbon\Carbon;
use App\Models\Branch;
use Faker\Factory as Faker;
use App\Models\DepartmentType;
use Illuminate\Database\Seeder;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Faker::create();

        DB::table('departments')->truncate();

        $branch =   Branch::whereName('Branch 1')->get()->first();
        $outlet  =   DepartmentType::whereCode('outlet')->get()->first();

        DB::table('departments')->insert([
            [
                'branch_id'             =>  $branch->id,
                'name'                  =>  'Вино-водочный',
                'description'           =>  'Продажа алкогольных и слабоалкогольных продуктов, сигареты',
                'department_type_id'    =>  $outlet->id,
                'flag'                  =>  3,
                'opened'                =>  $faker->dateTimeBetween($startDate = $branch->opened, $endDate='-1 month')
            ],
            [
                'branch_id'             =>  $branch->id,
                'name'                  =>  'Гастрономия',
                'description'           =>  'Хлебо-булочные изделия, колбасы, кисло-молочные изделия, крупы',
                'department_type_id'    =>  $outlet->id,
                'flag'                  =>  3,
                'opened'                =>  $faker->dateTimeBetween($startDate = $branch->opened, $endDate='-1 month')
            ],
            [
                'branch_id'             =>  $branch->id,
                'name'                  =>  'Овощной',
                'description'           =>  'Овощи, консервы, рыба',
                'department_type_id'    =>  $outlet->id,
                'flag'                  =>  3,
                'opened'                =>  $faker->dateTimeBetween($startDate = $branch->opened, $endDate='-1 month')
            ],
            [
                'branch_id'             =>  $branch->id,
                'name'                  =>  'Ларек "Овощи и фрукты"',
                'description'           =>  'Фрукты и овощи',
                'department_type_id'    =>  $outlet->id,
                'flag'                  =>  3,
                'opened'                =>  $faker->dateTimeBetween($startDate = $branch->opened, $endDate='-1 month')
            ],
            [
                'branch_id'             =>  $branch->id,
                'name'                  =>  'Склад',
                'description'           =>  'Овощной склад',
                'department_type_id'    =>  DepartmentType::whereCode('stock')->get()->first()->id,
                'flag'                  =>  1,
                'opened'                =>  $faker->dateTimeBetween($startDate = $branch->opened, $endDate='-1 month')
            ],
            [
                'branch_id'             =>  $branch->id,
                'name'                  =>  'Кафе',
                'description'           =>  'Кафе',
                'department_type_id'    =>  $outlet->id,
                'flag'                  =>  3,
                'opened'                =>  $faker->dateTimeBetween($startDate = $branch->opened, $endDate='-1 month')
            ],
            [
                'branch_id'             =>  $branch->id,
                'name'                  =>  'Кухня',
                'description'           =>  'Кухня кафе',
                'department_type_id'    =>  DepartmentType::whereCode('production')->get()->first()->id,
                'flag'                  =>  1,
                'opened'                =>  $faker->dateTimeBetween($startDate = $branch->opened, $endDate='-1 month')
            ],
            [
                'branch_id'             =>  $branch->id,
                'name'                  =>  'Пирожковая',
                'description'           =>  'Цех производства пирожков, беляшей',
                'department_type_id'    =>  DepartmentType::whereCode('production')->get()->first()->id,
                'flag'                  =>  1,
                'opened'                =>  $faker->dateTimeBetween($startDate = $branch->opened, $endDate='-1 month')
            ],
            [
                'branch_id'             =>  $branch->id,
                'name'                  =>  'Чебуречная',
                'description'           =>  'Цех производства чебуреков',
                'department_type_id'    =>  DepartmentType::whereCode('production')->get()->first()->id,
                'flag'                  =>  1,
                'opened'                =>  $faker->dateTimeBetween($startDate = $branch->opened, $endDate='-1 month')
            ],
            [
                'branch_id'             =>  $branch->id,
                'name'                  =>  'Бильярдная',
                'description'           =>  'Ганделик',
                'department_type_id'    =>  $outlet->id,
                'flag'                  =>  3,
                'opened'                =>  $faker->dateTimeBetween($startDate = $branch->opened, $endDate='-1 month')
            ],            
        ]);

       

        $branch = Branch::whereName('Branch 2')->get()->first();
        DB::table('departments')->insert([
            [
                'branch_id'             =>  $branch->id,
                'name'                  =>  "Branch 2. Вино-водочный",
                'description'           =>  $faker->sentence(6),
                'department_type_id'    =>  $outlet->id,
                'flag'                  =>  3,
                'opened'                =>  $faker->dateTimeBetween($startDate = $branch->opened, $endDate='-1 month')
            ],
            [
                'branch_id'             =>  $branch->id,
                'name'                  =>  "Branch 2. Овощной",
                'description'           =>  $faker->sentence(6),
                'department_type_id'    =>  $outlet->id,
                'flag'                  =>  3,
                'opened'                =>  $faker->dateTimeBetween($startDate = $branch->opened, $endDate='-1 month')                
            ],
        ]);
        
    }
}
