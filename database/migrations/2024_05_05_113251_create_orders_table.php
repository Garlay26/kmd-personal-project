<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number');
            $table->dateTime('date');
            $table->bigInteger('customer_id');
            $table->bigInteger('country_id')->nullable();
            $table->bigInteger('state_id')->nullable();
            $table->bigInteger('township_id')->nullable();
            $table->bigInteger('delivery_time_id')->nullable();
            $table->string('receiver_name')->nullable();
            $table->string('receiver_phone')->nullable();
            $table->string('note')->nullable();
            $table->string('address')->nullable();
            $table->LongText('remark')->nullable();
            $table->bigInteger('coupon_id')->nullable();
            $table->bigInteger('discount_amount')->default(0);
            $table->bigInteger('total_amount')->default(0);
            $table->enum('status', ['pending', 'approved','refund','cancel'])->default('pending');
            $table->bigInteger('payment_method_id')->nullable();
            $table->string('payment_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
