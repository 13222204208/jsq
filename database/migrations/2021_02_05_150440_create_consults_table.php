<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consults', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->tinyInteger('consult_type_id')->comment('分类名称id');
            $table->string('cover')->default('http://n.sinaimg.cn/news/crawl/283/w550h533/20210110/6a20-khmynua1870806.jpg')->comment('封面图');
            $table->text('content');
            $table->timestamps();

            $table->comment="参考内容";
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consults');
    }
}
