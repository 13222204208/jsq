<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_members', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('team_id')->comment('团队的id');
            $table->tinyInteger('user_id')->comment('成员用户的id');
            $table->tinyInteger('status')->default(1)->comment('团队成员状态，1正常，2禁用');
            $table->timestamps();

            $table->comment= "团队成员表";
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('team_members');
    }
}
