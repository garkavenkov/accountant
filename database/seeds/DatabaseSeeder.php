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
        $this->call(IncomeDocumentsSeeder::class);
        $this->call(IncomeDocumentItemsSeeder::class);
        $this->call(CashSeeder::class);
        $this->call(SalesRevenueSeeder::class);
    }
}
