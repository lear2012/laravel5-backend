<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKeyeContacts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('keye_contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('company_name')->nullable()->comment('公司名称');
            $table->string('name')->comment('联系人');
            $table->string('phone')->comment('联系方式');
            $table->string('content')->nullable()->comment('内容');
            $table->tinyInteger('contact_type')->default(1)->comment('联系类型，1为联系我们，2为商务洽谈');
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
        Schema::drop('keye_contacts');
    }
}
