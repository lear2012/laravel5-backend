<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('uid')->unsigned()->unqiue()->comment('用户唯一uid');
            $table->string('real_name')->nullable()->comment('真实姓名');
            $table->string('id_no')->nullable()->comment('身份证号');
            $table->string('member_no')->nullable()->comment('付费会员编号');
            $table->string('invite_no')->nullable()->comment('邀请码');
            $table->integer('keye_age')->nullable()->comment('可野龄');
            $table->string('quotation')->nullable()->comment('引用语句');
            $table->text('nest_info')->nullable()->comment('老司机个人页面自定义呈现');
            $table->string('avatar')->nullable()->comment('头像');

            // 微信相关信息
            $table->string('wechat_id')->nullable()->unique()->comment('微信id');
            $table->string('wechat_no')->nullable()->unique()->comment('微信号');
            $table->tinyInteger('sex')->unsigned()->default(0)->comment('0未知, 1男，2女');
            // 收货地址信息
            $table->char('province', 6)->nullable()->comment('收货省份');
            $table->char('city', 6)->nullable()->comment('收货城市');
            $table->char('dist', 6)->nullable()->comment('区');
            $table->string('address')->nullable()->comment('收货详细地址');
            // 车辆信息
            $table->string('brand')->nullable()->comment('车辆品牌信息');
            $table->string('series')->nullable()->comment('车辆车系信息');
            $table->string('year')->nullable()->comment('车辆年份信息');

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
    }
}
