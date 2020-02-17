<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDrivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drives', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('tabelnomer');
            $table->integer('garajnomer');
            $table->string('driverfio');
            $table->string('avto');
            $table->string('gosnomer');
            $table->string('regnomer1');
            $table->string('regnomer2');
            $table->string('regnomer3');
            $table->integer('firmaid');
            $table->string('ydost1');
            $table->string('ydost2');
            $table->string('fiosmal');

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
        Schema::dropIfExists('drives');
    }
}
