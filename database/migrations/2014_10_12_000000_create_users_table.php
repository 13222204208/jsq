<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('');
            $table->string('phone')->unique()->default('');
            $table->string('email')->unique()->default('');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('branch')->default('')->comment('组织名称');
            $table->string('medical_allergy')->default('')->comment('医疗过敏');
            $table->string('linkman_one_name')->default('')->comment('联系人姓名');
            $table->string('linkman_one_phone')->default('')->comment('联系人电话');
            $table->string('linkman_two_name')->default('')->comment('联系人姓名');
            $table->string('linkman_two_phone')->default('')->comment('联系人电话');
            $table->string('avatar')->default('https://wpimg.wallstcn.com/f778738c-e4f8-4870-b634-56703b4acafe.gif')->comment('头像');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
