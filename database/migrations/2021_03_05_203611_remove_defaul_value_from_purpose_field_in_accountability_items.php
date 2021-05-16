<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveDefaulValueFromPurposeFieldInAccountabilityItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accountability_items', function (Blueprint $table) {
            $table->string('purpose')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('accountability_items', function (Blueprint $table) {
            $table->string('purpose')->nullable(true)->change();
        });
    }
}
