<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotepadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notepads', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('')->comment('记事本的标题');
            $table->text('content')->comment('记事本的内容');
            $table->unsignedInteger('user_id')->comment('记事本的用户id');
            $table->tinyInteger('status')->default(1)->comment('1正常，2禁用');
            $table->timestamps();

            $table->comment= "记事本";
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notepads');
    }
}
