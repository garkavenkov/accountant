<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUniqueKeyForRestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rests', function (Blueprint $table) {
            $table->unique(['rest_type_id', 'owner_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rests', function (Blueprint $table) {
            $table->dropUnique('rests_rest_type_id_owner_id_date_unique');
        });
    }
}
