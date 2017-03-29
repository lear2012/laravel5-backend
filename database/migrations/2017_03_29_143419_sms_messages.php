<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SmsMessages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('sms_messages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable()->comment('邀请人uid');
            $table->integer('wechat_no')->unsigned()->nullable()->comment('短信发起人微信号');
            $table->string('ip')->comment('ip地址');
            $table->string('message')->comment('邀请码');
            $table->tinyInteger('message_type')->default(0)->comment('消息类型，1注册短信验证');
            $table->tinyInteger('result')->default(1)->comment('发送成功与否');
            $table->integer('created_at');
            $table->integer('updated_at');
            $table->softDeletes()->comment('软删除时间');

            $table->index(['wechat_no', 'message_type']);
            $table->index(['ip', 'message_type']);
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
        Schema::drop('sms_messages');
    }
}
