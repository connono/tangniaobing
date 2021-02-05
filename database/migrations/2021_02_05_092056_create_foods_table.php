<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('foods', function (Blueprint $table) {
            $table->id();
            // 食品名称
            $table->string('name');
            // 食品GI
            $table->integer('gi');
            // 食品类型
            // 1 表示主食，2 表示奶类，3 表示蔬菜菌类，4 表示豆制品，
            // 5 表示豆制品，6 表示饮料，7 表示油脂类，8 表示调味品，
            // 9 表示零食点心，10 表示其他，11 表示菜肴
            // $table->enum('type',[1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]);
            // 每一百克卡路里
            $table->integer('energy');
            // 碳水化合物（g）
            $table->integer('carbohydrate');
            // 脂肪（g）
            $table->integer('axunge');
            // 蛋白质（g）
            $table->integer('protein');
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
        Schema::dropIfExists('foods');
    }
}
