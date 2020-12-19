<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUniqueIndexForShiftEmployessIntoShiftEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shift_employees', function (Blueprint $table) {            
            $table->unique(['shift_id', 'employee_id'], 'unique_employee_per_shift');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shift_employees', function (Blueprint $table) {            
            $table->dropUnique('unique_employee_per_shift');
        });
    }
}
