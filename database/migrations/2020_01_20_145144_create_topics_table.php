<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->comment('话题用户ID');
            $table->string('title')->comment('话题标题');
            $table->string('short')->nullable()->comment('内容简要');
            $table->longText('body')->comment('话题内容');
            $table->tinyInteger('status')->comment('话题状态 0-审核中，1-正常，2-举报，3-违规');
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
        Schema::dropIfExists('topics');
    }
}
