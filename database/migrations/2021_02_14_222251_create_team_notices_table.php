<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamNoticesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_notices', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('team_id')->comment('团队的id');
            $table->tinyInteger('user_id')->comment('成功加入用户的id');
            $table->string('content')->comment('消息的内容');
            $table->tinyInteger('state')->default(0)->comment('0,未读， 1已读');
            $table->timestamps();

            $table->comment="成功加入团队通知表 团队创始人接收的消息";
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('team_notices');
    }
}
