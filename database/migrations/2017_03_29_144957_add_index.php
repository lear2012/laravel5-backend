<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIndex extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('users', function (Blueprint $table) {
            $table->index('mobile');
            $table->index('email');
        });
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->index(['real_name', 'id_no']);
            $table->index('wechat_id');
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->index('wechat_openid');
            $table->index('order_type');
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
