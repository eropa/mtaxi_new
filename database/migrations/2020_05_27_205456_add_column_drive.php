<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnDrive extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('drives', function (Blueprint $table) {
            $table->integer('setTime')->nullable()->default(0);
            $table->integer('hStart')->nullable()->default(0);
            $table->integer('mStart')->nullable()->default(0);
            $table->integer('hEnd')->nullable()->default(0);
            $table->integer('mEnd')->nullable()->default(0);
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
