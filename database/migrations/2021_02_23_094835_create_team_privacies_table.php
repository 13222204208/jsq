<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamPrivaciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_privacies', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('标题');
            $table->string('background')->comment('背景图');
            $table->text('content')->comment('内容');
            $table->timestamps();

            $table->comment="开通会员页面团队隐私表";
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('team_privacies');
    }
}
