<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeIdFieldIntoCashOperationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cash_operations', function (Blueprint $table) {
            $table->smallInteger('type_id')
                    ->default(1)
                    ->after('name')
                    ->comment('1 - debet, 2 - credit');
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
            $table->dropColumn('type_id');
        });
    }
}
