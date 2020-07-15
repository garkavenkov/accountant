<?php

use Illuminate\Database\Seeder;

class SuppliersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('suppliers')->truncate();

        DB::table('suppliers')->insert([
            [
                'name' => 'Корунд',
                'full_name' => 'Корунд',
                'description' => 'Грибы'
            ],
            [
                'name' => 'Степан-рыба',
                'full_name' => 'Степан-рыба',
                'description' => 'Рыба'
            ],
            [
                'name' => 'Ежик',
                'full_name' => 'Ежик',
                'description' => 'Солка'
            ],
            [
                'name' => 'Мясноф',
                'full_name' => 'Мясноф',
                'description' => 'Корм для животных'
            ],
            [
                'name' => 'Б.О.Т.',
                'full_name' => 'БакалеяОптТорг',
                'description' => 'Масло растительное'
            ],
            [
                'name' => 'Чабанов',
                'full_name' => 'ФЛП Чабанов Роман Викторович',
                'description' => 'Маринованные продукты'
            ],
            [
                'name' => 'Одноралова Н.А,',
                'full_name' => 'ФЛП Одноралова Н.А.',
                'description' => 'Розливная питьевая вода'
            ],
            [
                'name' => 'Мохаммад',
                'full_name' => 'Мохаммад',
                'description' => 'Консервация'
            ],
            [
                'name' => 'Атлант',
                'full_name' => 'Атлант',
                'description' => 'Икра'
            ],
            [
                'name' => 'Потенциал',
                'full_name' => 'ООО "Торговый дом "Потенциал"',
                'description' => 'Масло растительное'
            ],
            [
                'name' => 'Мастер-торг',
                'full_name' => 'ООО "Мастер-торг"',
                'description' => 'Вино, слабоалкогольные напитки'
            ],
            [
                'name' => 'Виола',
                'full_name' => 'ООО "Торговый дом "Виола"',
                'description' => 'Водка'
            ],
            [
                'name' => 'Фуд лайн трейнинг-2014',
                'full_name' => 'ООО ""Фуд лайн трейнинг-2014"',
                'description' => 'Пиво'
            ],
            [
                'name' => 'Злата',
                'full_name' => 'ООО "Злата"',
                'description' => 'Сигареты'
            ],
            [
                'name' => 'Доровской',
                'full_name' => 'Доровской',
                'description' => 'Безалкогольные напитки'
            ],
            [
                'name' => 'Лидер',
                'full_name' => 'Лидер',
                'description' => 'Вода, напитки'
            ],
            [
                'name' => 'Велес',
                'full_name' => 'Велес',
                'description' => 'Коньк'
            ],
            [
                'name' => 'Купец',
                'full_name' => 'ООО "Купец"',
                'description' => 'Вода'
            ],
            [
                'name' => 'Табачный дворъ',
                'full_name' => 'Табачный дворъ',
                'description' => 'Сигареты'
            ],
            [
                'name' => 'Донецкий хлеб',
                'full_name' => 'Донецкий хлеб',
                'description' => 'Хлебо-булочные изделия'
            ],
            [
                'name' => 'Мясной бум',
                'full_name' => 'Мясной бум',
                'description' => 'Мясо'
            ],
            [
                'name' => 'Третьяков',
                'full_name' => 'Третьяков',
                'description' => 'Чай, кофе'
            ],
            [
                'name' => 'Хлебторг',
                'full_name' => 'ООО "Хлебторг"',
                'description' => 'Хлебо-булочные изделия'
            ],
            [
                'name' => 'Семенюк',
                'full_name' => 'ЧП Семенюк',
                'description' => 'Хлебо-булочные изделия'
            ],
            [
                'name' => 'Марченко В.В.',
                'full_name' => 'ЧП Марченко В.В.',
                'description' => 'Крупа, печенье'
            ],
            [
                'name' => 'Мак-инвест',
                'full_name' => 'ООО "Мак-инвест"',
                'description' => 'Конфеты'
            ],
            [
                'name' => 'Горняк',
                'full_name' => 'Горняк',
                'description' => 'Колбаса'
            ],
            [
                'name' => 'Колбико',
                'full_name' => 'ООО "Колбико"',
                'description' => 'Колбаса'
            ],
        ]);
    }
}
