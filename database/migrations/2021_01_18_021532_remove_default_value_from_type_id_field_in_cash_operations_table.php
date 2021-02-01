<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveDefaultValueFromTypeIdFieldInCashOperationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cash_operations', function (Blueprint $table) {
            $table->smallInteger('type_id')->nullable(false)->default(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cash_operations', function (Blueprint $table) {
            $table->smallInteger('type_id')->default(1)->change();
        });
    }
}
