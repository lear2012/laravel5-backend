<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvitations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('invitations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->default(0)->comment('邀请人uid, 0代表可野');
            $table->integer('invited_user_id')->unsigned()->nullable()->comment('使用人uid');
            $table->string('invitation_code')->comment('邀请码');
            $table->tinyInteger('used')->default(0)->comment('是否已用');
            $table->tinyInteger('active')->default(1)->comment('是否激活');
            $table->integer('created_at');
            $table->integer('updated_at');
            $table->softDeletes()->comment('软删除时间');

            $table->index('user_id');

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
        Schema::drop('invitations');
    }
}
