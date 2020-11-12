<?php

use Carbon\Carbon;
use App\Models\Cash;
use App\Models\Payment;
use Faker\Factory as Faker;
use App\Models\CashDocument;
use App\Models\CashOperation;
use App\Models\IncomeDocument;
use App\Models\LinkedDocument;
use Illuminate\Database\Seeder;
use App\Models\LinkedDocumentType;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('ru_RU');  

        CashDocument::payments()->delete();
        
        $documents = IncomeDocument::all();
        
        $cashes = Cash::get();
        
        $operation_id = CashOperation::where('code', 'payment')->first()->id;

        $link_type = LinkedDocumentType::where('code', 'payment')->first();

        for ($i=0; $i < ( $documents->count() / 4) ; $i++) { 

            $document =   $faker->randomElement($documents);
                           
            $endDate    = Carbon::createFromFormat('Y-m-d', $document->date)->addWeeks(2);

            $date = $faker->dateTimeBetween($startDate = $document->date, $endDate, $timezome='Europe/Moscow')->format("Y-m-d");
            
            $sum = $document->sum1;
            
            $cash = $document->department->branch->cash;
            
            $purpose = 'Погашение задолженности за товар согл. накладной от "' . Carbon::parse($document->date)->formatLocalized('%d.%m.%Y') . '"';

            $cash_document_id = DB::table('cash_documents')->insertGetId([
                'operation_id'          =>  $operation_id,
                'date'                  =>  $date,
                'number'                =>  $i+1,
                'debet_id'              =>  $cash->id,
                'credit_id'             =>  $document->supplier->id,                
                'purpose'               =>  $purpose,
                'debet'                 =>  $sum,
                'user_id'               =>  1 
            ]);
            
            $link = new LinkedDocument([
                'type_id'           =>  $link_type->id,
                'cash_document_id'  =>  $cash_document_id,
                'owner_id'          =>  $document->id
            ]);
          
            $link->save();
          
            $document->status = 1;
            $document->save();

            $documents->forget($document->id);
        }
        
    }
}
