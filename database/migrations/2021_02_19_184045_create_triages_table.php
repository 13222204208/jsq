<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTriagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('triages', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('minor_wound')->default(0)->comment('轻伤');
            $table->tinyInteger('moderate_wound')->default(0)->comment('中度伤');
            $table->tinyInteger('serious_injuries')->default(0)->comment('重伤');
            $table->tinyInteger('death')->default(0)->comment('死亡');
            $table->tinyInteger('status')->default(1)->comment('1正常，2禁用');
            $table->unsignedInteger('user_id')->comment('用户id');
            $table->timestamps();

            $table->comment="检伤分类表";
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('triages');
    }
}
