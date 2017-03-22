<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSeries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('series', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unqiue()->comment('车系code,md5值');
            $table->integer('brand_id')->comment('brand id');
            $table->string('name')->comment('车系名称');
            $table->string('detail')->nullable()->comment('车系介绍');
            $table->tinyInteger('active')->unsigned()->default(1)->comment('1启用，0禁用');
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
        Schema::drop('series');
    }
}
