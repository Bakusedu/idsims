<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnDefaultOfDrugsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('drugs', function ($table) {
            $table->text('effects')->nullable()->change();
            $table->text('interaction')->nullable()->change();
            $table->unsignedBigInteger('vendor_id')->nullable()->change();
            $table->text('overdose')->nullable()->change();
            $table->text('dosage')->nullable()->change();
            $table->text('note')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
