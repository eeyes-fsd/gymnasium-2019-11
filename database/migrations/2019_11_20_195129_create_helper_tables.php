<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHelperTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exercise', function (Blueprint $table) {
            $table->increments('id');
            $table->string('content');
            $table->timestamps();
        });

        Schema::create('purpose', function (Blueprint $table) {
            $table->increments('id');
            $table->string('content');
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
        Schema::dropIfExists('exercise');
        Schema::dropIfExists('purpose');
    }
}
