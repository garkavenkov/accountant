<?php

use Illuminate\Database\Seeder;
use App\Models\LinkedDocumentType;

class LinkedDocumentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LinkedDocumentType::truncate();

        DB::table('linked_document_types')->insert(
            [            
                'code'  =>  'payment',
                'name'  =>  'Оплата за товар'
            ],
            [            
                'code'  =>  'loan',
                'name'  =>  'Получение кредита'
            ],
            [            
                'code'  =>  'loan_repayment',
                'name'  =>  'Погашение кредита'
            ],
        );        
    }
}
