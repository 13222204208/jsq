<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique()->comment('团队名称');
            $table->unsignedInteger('initiator_id')->comment('创始人id');
            $table->tinyInteger('status')->default(1)->comment('1,正常，2禁用');
            $table->tinyInteger('duration')->default(1)->comment('1,包年，2终身');
            $table->string('stop_time')->default('')->comment('截止时间');
            $table->string('cover')->default('imgs/team/team_icon.png')->comment('团队图标');
            $table->tinyInteger('team_state')->default(1)->comment('1,私有的，2公开的');
            $table->timestamps();

            $table->comment='团队表';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teams');
    }
}
