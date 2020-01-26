<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMoreFieldsToDrugsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('drugs', function (Blueprint $table) {
            $table->string('nafdac');
            $table->string('expiry_date');
    });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('drugs', function (Blueprint $table) {
            $table->dropColumn('nafdac');
            $table->dropColumn('expiry');
        });
    }
}
