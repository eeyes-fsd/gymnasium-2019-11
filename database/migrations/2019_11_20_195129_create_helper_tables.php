<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateHelperTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exercises', function (Blueprint $table) {
            $table->increments('id');
            $table->string('content');
        });

        DB::table('exercises')->insert([
            ['content' => '每周0-1次'],
            ['content' => '每周2-3次'],
            ['content' => '每周4次及以上'],
        ]);

        Schema::create('purposes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('content');
        });

        DB::table('purposes')->insert([
            ['content' => '减重'],
            ['content' => '急速减重'],
            ['content' => '增重'],
            ['content' => '保持体重'],
            ['content' => '减脂'],
            ['content' => '增肌'],
            ['content' => '增强体质'],
        ]);

        Schema::create('habits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('content');
        });

        DB::table('habits')->insert([
            ['content' => '一日三餐'],
            ['content' => '三餐加一次加餐'],
            ['content' => '三餐加两次加餐'],
            ['content' => '三餐加三次加餐'],
        ]);

        Schema::create('ingredients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->integer('price')->comment('价格 分/克');
            $table->float('carbohydrate')->comment('碳水化合物 kCal/g');
            $table->float('protein')->comment('蛋白质 kCal/g');
            $table->float('fat')->comment('脂肪 kCal/g');
            $table->timestamps();
        });

        Schema::create('deliver_fee', function (Blueprint $table) {
            $table->float('lb');
            $table->float('ub');
            $table->float('fee');
        });

        Schema::create('weight_fee', function (Blueprint $table) {
            $table->float('lb');
            $table->float('ub');
            $table->float('fee');
        });

        Schema::create('time_fee', function (Blueprint $table) {
            $table->float('lb');
            $table->float('ub');
            $table->float('fee');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exercises');
        Schema::dropIfExists('purposes');
        Schema::dropIfExists('ingredients');
        Schema::dropIfExists('habits');
        Schema::dropIfExists('deliver_fee');
        Schema::dropIfExists('weight_fee');
        Schema::dropIfExists('time_fee');
    }
}
