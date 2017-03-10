<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('oid')->unsigned()->unqiue()->comment('订单唯一oid');
            $table->string('title')->comment('订单title');
            $table->string('detail')->nullable()->comment('订单详细说明');
            $table->string('wechat_openid')->comment('付费微信号');
            $table->string('wechat_no')->comment('付费微信号');
            $table->decimal('amount', 12, 2)->comment('支付金额');
            $table->string('memo')->nullable()->comment('订单备注');
            $table->tinyInteger('order_type')->unsigned()->default(0)->comment('1可野人会费');
            $table->tinyInteger('status')->unsigned()->default(1)->comment('1已下单，2支付完成，3退款');
            $table->integer('pay_at')->nullable()->comment('支付时间');
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
    }
}
