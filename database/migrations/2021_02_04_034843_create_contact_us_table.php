<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactUsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_us', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('姓名');
            $table->string('phone')->comment('手机号');
            $table->string('email')->default('')->comment('邮箱');
            $table->string('team')->default('')->comment('团队');
            $table->text('news')->comment('消息');
            $table->tinyInteger('status')->default(1)->comment('1 未处理，2已处理');
            $table->timestamps();

            $table->comment= "联系我们";
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contact_us');
    }
}
