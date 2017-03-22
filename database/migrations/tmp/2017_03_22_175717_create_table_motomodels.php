<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMotomodels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('motomodels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unqiue()->comment('车型code,md5值');
            $table->integer('sery_id')->comment('sery id');
            $table->string('name')->comment('车型名称');
            $table->string('detail')->nullable()->comment('车型介绍');
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
        Schema::drop('motomodels');
    }
}
