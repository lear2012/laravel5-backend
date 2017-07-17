<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTopicImage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('topic_images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('路线标题');
            $table->string('cover_img')->nullable()->comment('专题图片');
            $table->string('url')->comment('专题链接');
            $table->tinyInteger('active')->default(1)->comment('是否激活');
            $table->integer('created_at');
            $table->integer('updated_at');
            $table->softDeletes()->comment('软删除时间');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::drop('topic_images');
    }
}
