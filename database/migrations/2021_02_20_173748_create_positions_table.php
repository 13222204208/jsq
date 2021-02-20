<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->string('type_name')->comment('类型名称');
            $table->string('icon')->default('')->comment('图标');
            $table->string('comment')->default('')->comment('备注');
            $table->string('address')->default('')->comment('地址');
            $table->unsignedBigInteger('user_id')->default(0)->comment('设置位置的用户id');
            $table->string('long')->comment('经度');
            $table->string('lat')->comment('纬度');
            $table->tinyInteger('status')->default(1)->comment('1,正常，2禁用');
            $table->timestamps();

            $table->comment= "设置位置表";
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('positions');
    }
}
