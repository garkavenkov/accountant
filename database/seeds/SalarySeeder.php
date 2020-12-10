<?php

use App\Models\Employee;
use Faker\Factory as Faker;
use App\Models\CashDocument;
use App\Models\CashOperation;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;

class SalarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('ru_RU');  

        CashDocument::salaries()->delete();
        
        $operation_id = CashOperation::where('code', 'salary')->first()->id;

        $employees = Employee::get();

        $startDate  = Carbon::createFromFormat('Y-m-d','2020-11-01');
        $endDate    = Carbon::createFromFormat('Y-m-d','2020-11-30');

        $i = 0;

        foreach ($employees as $employee) {

            $date = $faker->dateTimeBetween($startDate, $endDate, $timezome='Europe/Moscow')->format("Y-m-d");
            
            // dd($employee->salary($date)->type->code);

            switch ($employee->salary($date)->type->code) {
                case 'salary':
                    $d = Carbon::createFromFormat('Y-m-d', $date);                    
                    $d->locale("ru_RU");
                    // dd($d->getTranslatedMonthName(), $d->year);
                    $amount = $employee->salary($date)->amount;
                    $purpose = 'Начисленная зарплата за ' . $d->getTranslatedMonthName() . ' ' . $d->year;
                    break;
                case 'daily':
                    // dd($employee->salary($date));
                    $amount = $employee->salary($date)->amount;
                    $purpose = 'Начисленная зарплата за ' . $date;
                    break;
                case 'percent':
                    // dd($employee->id, $date, $employee->salary($date));
                    $sales_revenue = (float) $employee->department->currentShift($date)->salesRevenue()['total'];
                    $amount = ($sales_revenue / 100 ) * (float) $employee->salary($date)->amount;
                    $purpose =  'Начисленная зарплата за период с ' . 
                                $employee->department->currentShift($date)->salesRevenue()['date_begin'] .
                                ' по ' . $employee->department->currentShift($date)->salesRevenue()['date_end'] .
                                ' ( ' . $employee->salary($date)->amount .  '%)';
                                     
                    break;
                default:
                    $amount = 100;
                    break;
            }
            // dd($purpose);   
            DB::table('cash_documents')->insert([
                'operation_id'          =>  $operation_id,
                'date'                  =>  $date,
                'number'                =>  $i++,
                'debet_id'              =>  $employee->department->branch->cash->id,
                'credit_id'             =>  $employee->id,
                'purpose'               =>  $purpose,
                'debet'                 =>  $amount,
                'user_id'               =>  1 
            ]);

        }
        
    }
}
