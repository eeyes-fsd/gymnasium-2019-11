<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('user_id');
            $table->integer('service_id')->comment('服务点ID');
            $table->integer('fee')->comment('订单总价');
            $table->integer('address_id')->nullable()->comment('送货地址');
            $table->dateTime('deliver_at')->nullable()->comment('配送时间');
            $table->longText('details');
            $table->uuid('refund_no')->nullable()->comment('退款单号');
            $table->smallInteger('status')->comment('订单状态：0-未支付，1-已支付，-1-已取消');
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
        Schema::dropIfExists('orders');
    }
}
