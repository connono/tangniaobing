<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBloodGlucoseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blood_glucose', function (Blueprint $table) {
            $table->id();
            // 对应的患者id
            $table->bigInteger('user_id')->index();
            // 血糖值
            $table->integer('blood_glucose');
            // 类型
            // 0 表示早餐前，1 表示早餐后，2 表示午餐前，
            // 3 表示午餐后，4 表示晚餐前，5 表示晚餐后，
            $table->enum('type',[0, 1, 2, 3, 4, 5]);
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
        Schema::dropIfExists('blood_glucoses');
    }
}
