<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFoodTypeCount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('foods', function($table) {
            $table->enum('type', ['vegetable', 'fruit', 'cereal', 'beanProduct', 'grease', 'meat']);
            $table->integer('g');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('foods', function($table) {
            $table->dropColumn('type');
            $table->dropColumn('g'); 
        });
    }
}
