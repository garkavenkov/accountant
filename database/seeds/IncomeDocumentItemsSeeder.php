<?php

use App\Models\Measure;
use Faker\Factory as Faker;
use App\Models\IncomeDocument;
use Illuminate\Database\Seeder;

class IncomeDocumentItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('ru_RU');       
        
        $doc = IncomeDocument::first();
        $measure_id = Measure::first()->id;
        
        DB::table('document_items')->truncate();

        for ($i=0; $i < 5; $i++) { 

            $qty            =   $faker->randomDigitNot(0);
            $price          =   $faker->numberBetween($min = 10, $max = 500);

            DB::table('document_items')->insert(
                [        
                    'document_id'       =>  $doc->id,
                    'number'            =>  $i,
                    'name'              =>  "Спецификания {$i}",
                    'measure_id'        =>  $measure_id,
                    'quantity'          =>  $qty,
                    'price'             =>  $price,
                    'price2'            =>  $price * 1.2
                ]
            );

        }
        
    }
}
