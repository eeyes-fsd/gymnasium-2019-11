<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meals', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('ID');
            $table->longText('ingredients')->comment('食材');
            $table->integer('carbohydrate')->nullable()->comment('碳水化合物');
            $table->integer('fat')->nullable()->comment('脂肪');
            $table->integer('protein')->nullable()->comment('蛋白质');
            $table->longText('step')->comment('步骤');
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
        Schema::dropIfExists('meals');
    }
}
