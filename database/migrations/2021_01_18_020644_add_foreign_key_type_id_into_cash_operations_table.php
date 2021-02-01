<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyTypeIdIntoCashOperationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cash_operations', function (Blueprint $table) {
            $table->foreign('type_id')->references('id')->on('cash_operation_types');
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
            $table->dropForeign('cash_operations_type_id_foreign');
        });
    }
}
