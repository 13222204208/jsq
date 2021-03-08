<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJoinTeamNoticesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('join_team_notices', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('status')->default(0)->comment('1,同意加入，2，拒绝加入');
            $table->tinyInteger('inviter_user_id')->default(0)->comment('邀请人的id');
            $table->tinyInteger('team_id')->comment('团队的id');
            $table->string('msg_content')->comment('消息内容');
            $table->tinyInteger('user_id')->comment('申请用户的id');
            $table->tinyInteger('state')->default(0)->comment('0,未读， 1已读');
            $table->timestamps();

            $table->comment= "申请加入团队消息通知表";
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('join_team_notices');
    }
}
