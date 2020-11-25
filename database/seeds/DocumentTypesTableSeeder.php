<?php

use App\Models\DocumentType;
use Illuminate\Database\Seeder;

class DocumentTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DocumentType::truncate();

        DB::table('document_types')->insert([
            [            
                'code'  =>  'income',
                'name'  =>  'Товарная накладная'
            ],
            [            
                'code'  =>  'transfer',
                'name'  =>  'Трансферная накладная'
            ],
            [            
                'code'  =>  'expense',
                'name'  =>  'Трансферная накладная'
            ],
            [            
                'code'  =>  'markdown',
                'name'  =>  'Уценка товара'
            ],
        ]);        
    }
}
