<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKeyeRoutes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('keye_routes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('路线标题');
            $table->string('start')->comment('路线起点');
            $table->string('end')->comment('路线终点');
            $table->string('cover_img')->nullable()->comment('路线封面图片');
            $table->string('url')->comment('路线链接');
            $table->tinyInteger('ord')->comment('顺序');
            $table->bigInteger('votes')->default(0)->comment('支持数量');
            $table->tinyInteger('is_front')->default(0)->comment('是否推至首页');
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
        Schema::drop('keye_routes');
    }
}
