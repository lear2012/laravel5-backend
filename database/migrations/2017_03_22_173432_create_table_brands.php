<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBrands extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('brands', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unqiue()->comment('品牌code,md5值');
            $table->string('name')->comment('品牌名称');
            $table->string('detail')->nullable()->comment('品牌介绍');
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
        Schema::drop('brands');
    }
}
