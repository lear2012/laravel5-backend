<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSectionEnrollments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('section_enrollments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('姓名');
            $table->string('mobile')->comment('手机号');
            $table->string('wechat_no')->nullable()->comment('微信号');
            $table->tinyInteger('section_id')->comment('路段id, 1:新疆');
            $table->tinyInteger('reg_type')->default(1)->comment('注册类型, 1:自驾报名，2：摄像师报名');
            // 车辆信息
            $table->string('brand')->nullable()->comment('车辆品牌信息');
            $table->tinyInteger('status')->default(0)->comment('审核状态');
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
        Schema::drop('section_enrollments');
    }
}
