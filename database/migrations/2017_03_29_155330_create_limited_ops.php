<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLimitedOps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('limited_ops', function (Blueprint $table) {
            $table->increments('id');
            $table->string('identifier')->comment('操作人标示');
            $table->tinyInteger('action_type')->comment('操作类型, 1注册验证短信，2实名认证');
            $table->text('content')->comment('操作内容');
            $table->integer('created_at');
            $table->integer('updated_at');
            $table->softDeletes()->comment('软删除时间');

            $table->index(['identifier', 'action_type']);

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
        Schema::drop('limited_ops');
    }
}
