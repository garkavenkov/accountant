<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(BranchesTableSeeder::class);
        $this->call(DepartmentTypesTableSeeder::class);
        $this->call(DepartmentsTableSeeder::class);
        $this->call(PositionsTableSeeder::class);
        $this->call(EmployeesTableSeeder::class);
        $this->call(SuppliersTableSeeder::class);
        $this->call(ShiftsTableSeeder::class);
        $this->call(MeasuresTableSeeder::class);
        $this->call(DocumentTypesTableSeeder::class);
        $this->call(IncomeDocumentsSeeder::class);        
        $this->call(IncomeDocumentItemsSeeder::class);
        $this->call(TransferDocumentsSeeder::class);
        $this->call(ExpenseDocumentsSeeder::class);
        $this->call(MarkdownDocumentsSeeder::class);
        $this->call(WritedownDocumentsSeeder::class);
        $this->call(MarkupDocumentsSeeder::class);
        $this->call(CashSeeder::class);
        $this->call(CashOperationSeederTypeSeeder::class);
        $this->call(CashOperationSeeder::class);
        $this->call(SalesRevenueSeeder::class);
        $this->call(LinkedDocumentTypeSeeder::class);
        $this->call(PaymentSeeder::class);
        $this->call(SalaryTypeSeeder::class);
        $this->call(TariffRateSeeder::class);
        
    }
}
