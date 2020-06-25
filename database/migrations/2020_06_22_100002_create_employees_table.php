<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('surname');
            $table->string('name', 50);
            $table->string('patronymic');            
            $table->string('address');
            $table->date('birthdate');
            $table->smallInteger('department_id');
            $table->smallInteger('position_id');
            $table->date('hired');
            $table->date('fired')->nullable()->default(null);
            $table->timestamps();

            // $table->foreign('department_id')
            //     ->references('id')
            //     ->on('departments');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
