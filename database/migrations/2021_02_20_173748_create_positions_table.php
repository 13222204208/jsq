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
            $table->string('iconPath')->default('')->comment('图标');
            $table->string('comment')->default('')->comment('备注');
            $table->string('address')->default('')->comment('地址');
            $table->unsignedBigInteger('user_id')->default(0)->comment('设置位置的用户id');
            $table->string('longitude')->comment('经度');
            $table->string('latitude')->comment('纬度');

            $table->string('enter_time')->default('')->comment('进入时间');
            $table->string('evacuate_time')->default('')->comment('撤出时间');
            $table->string('team_name')->default('')->comment('团队名称');
            $table->string('hazard_type')->default('')->comment('危险类型');
            $table->tinyInteger('search_state')->default(0)->comment('1未搜索，2正在搜索，3搜索完成');
            $table->unsignedBigInteger('survivor')->default(0)->comment('生还者数量');
            $table->unsignedBigInteger('victim')->default(0)->comment('遇难者数量');

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
