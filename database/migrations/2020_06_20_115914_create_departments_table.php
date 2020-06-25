<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->smallInteger('branch_id')->unsigned();
            $table->string('name', 30);
            $table->string('description');
            $table->date('opened')->nullable();
            $table->date('closed')->nullable();
            $table->timestamps();

            // $table->unique(['branch_id', 'name']);
            
            // $table->foreign('branch_id')
            //     ->references('id')
            //     ->on('branches');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('departments');
    }
}
