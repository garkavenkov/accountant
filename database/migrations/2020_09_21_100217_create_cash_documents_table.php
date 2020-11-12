<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_documents', function (Blueprint $table) {
            $table->increments('id');
            $table->smallInteger('operation_id')->unsigned();
            $table->date('date');
            $table->smallInteger('number');
            $table->integer('debet_id');
            $table->integer('credit_id');
            $table->decimal('debet', 10, 2)->default(0);
            $table->decimal('credit', 10, 2)->default(0);
            $table->string('purpose');
            $table->tinyInteger('status')->default(0);
            $table->integer('user_id');
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
        Schema::dropIfExists('cash_documents');
    }
}
