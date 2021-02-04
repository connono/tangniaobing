<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('information', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->index();
            $table->string('phoneNumber');
            $table->enum('sex', ['男', '女']);
            $table->integer('height');
            $table->integer('age');
            $table->integer('weight');
            $table->binary('complication');
            $table->string('profession');
            $table->enum('sports', ['1', '2', '3']);
            $table->string('bg');
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
        Schema::dropIfExists('information');
    }
}
