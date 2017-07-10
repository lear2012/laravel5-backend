<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKeyeClubs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('keye_clubs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('club_name')->comment('俱乐部名称');
            $table->string('club_logo')->nullable()->comment('俱乐部logo');
            $table->string('name')->comment('联系人姓名');
            $table->string('mobile')->comment('手机号');
            $table->string('wechat_no')->nullabel()->comment('微信号');
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
        Schema::drop('keye_clubs');
    }
}
