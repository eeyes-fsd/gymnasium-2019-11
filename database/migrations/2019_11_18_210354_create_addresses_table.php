<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->comment('用户ID');
            $table->string('name')->comment('姓名');
            $table->string('phone')->comment('手机号码');
            $table->char('gender')->comment('性别（男 -> \'m\', 女 -> \'f\'）');
            $table->string('street')->comment('地址行');
            $table->string('details')->comment('详细地址');
            $table->double('longitude')->comment('地址经度');
            $table->double('latitude')->comment('地址纬度');
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
        Schema::dropIfExists('addresses');
    }
}
