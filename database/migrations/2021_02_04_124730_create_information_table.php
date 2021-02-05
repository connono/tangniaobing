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
            // user id
            $table->bigInteger('user_id')->index();
            // 性别 0为男 1为女
            $table->enum('sex', ['0', '1']);
            // 身高
            $table->integer('height');
            // 年龄
            $table->integer('age');
            // 体重
            $table->integer('weight');
            // 合并症 以标志位为准
            $table->binary('complication');
            // 职业
            $table->string('profession');
            // 运动情况
            $table->enum('sports', ['1', '2', '3']);
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
