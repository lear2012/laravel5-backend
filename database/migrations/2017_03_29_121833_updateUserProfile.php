<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUserProfile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->dropColumn('model');
            $table->dropColumn('year');
        });
        //
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->string('model')->after('series')->nullable()->comment('车型');
            $table->integer('year')->nullable()->after('model')->comment('购买年份信息');
            $table->integer('buy_year')->nullable()->after('year')->comment('购买年份信息');
            $table->tinyInteger('is_verified')->after('buy_year')->nullable()->comment('是否实名认证');
            $table->tinyInteger('self_get')->after('is_verified')->nullable()->comment('邮寄东西是否自取');
            $table->string('car_no')->after('model')->nullable()->comment('车牌号');
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
