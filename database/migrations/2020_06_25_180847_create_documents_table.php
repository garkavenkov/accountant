<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {            
            $table->increments('id');
            $table->date('date');
            // $table->smallInteger('document_type_id');
            $table->smallInteger('number');
            $table->smallInteger('debet_id');
            $table->smallInteger('debet_person_id')->default(0);
            $table->smallInteger('credit_id')->default(0);
            $table->smallInteger('credit_person_id')->default(0);
            $table->decimal('sum1', 10, 2);
            $table->decimal('sum2', 10, 2);
            $table->tinyInteger('status')->default(0);
            $table->smallInteger('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documents');
    }
}
