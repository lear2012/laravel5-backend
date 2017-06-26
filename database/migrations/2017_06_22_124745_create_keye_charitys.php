<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKeyeCharitys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('keye_charitys', function (Blueprint $table) {
            $table->increments('id');
            $table->string('subject')->comment('公益活动主题');
            $table->string('title')->comment('公益活动标题');
            $table->string('cover_img')->comment('公益活动封面图片');
            $table->string('detail_imgs')->comment('公益活动详情图片');
            $table->text('content')->comment('公益活动内容介绍');
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
        Schema::drop('keye_charitys');
    }
}
