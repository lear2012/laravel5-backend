<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKeyeEnrollments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('keye_enrollments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('姓名');
            $table->string('mobile')->comment('手机号');
            $table->string('start')->comment('路线起点');
            $table->string('end')->comment('路线终点');
            $table->string('wechat_no')->comment('微信号');
            // 车辆信息
            $table->string('brand')->nullable()->comment('车辆品牌信息');
            $table->string('series')->nullable()->comment('车辆车系信息');
            $table->string('year')->nullable()->comment('购买年份信息');
            // 可搭载人数
            $table->tinyInteger('available_seats')->default(0)->comment('可搭载人数');
            $table->tinyInteger('seats_taken')->default(0)->comment('已搭载人数');
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
        Schema::drop('keye_enrollments');
    }
}
