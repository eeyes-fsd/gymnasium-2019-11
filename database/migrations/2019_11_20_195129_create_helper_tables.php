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

        Schema::create('ingredients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
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
    }
}
