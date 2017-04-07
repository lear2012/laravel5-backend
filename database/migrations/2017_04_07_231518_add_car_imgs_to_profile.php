<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCarImgsToProfile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->string('car_imgs', 2000)->after('car_no')->nullable()->comment('用户车的图片');
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
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->dropColumn('car_imgs');
        });
    }
}
