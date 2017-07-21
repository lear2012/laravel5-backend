<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChetieApplys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('chetie_applys', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('姓名');
            $table->string('mobile')->comment('手机号');
            $table->string('brand')->comment('车型');
            $table->string('start')->comment('路线起点');
            $table->string('end')->comment('路线终点');
            $table->string('address')->comment('地址用以邮递');
            $table->string('detail')->comment('申请详情');
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
        Schema::drop('chetie_applys');
    }
}
