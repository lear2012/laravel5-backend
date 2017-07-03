<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKeyeLifts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('keye_lifts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('enrollment_id')->comment('自驾车辆报名id');
            $table->string('name')->comment('姓名');
            $table->string('mobile')->comment('手机号');
            $table->string('wechat_no')->comment('微信号');
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
        Schema::drop('keye_lifts');
    }
}
