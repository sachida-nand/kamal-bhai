<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use phpDocumentor\Reflection\Types\Nullable;

class CreateOrdersTable extends Migration
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
            $table->bigInteger('user_id')->unsigned();
            $table->string('order_id');
            $table->string('name');
            $table->string('mobile');
            $table->string('pincode')->nullable();
            $table->text('address_one');
            $table->text('address_two')->nullable();
            $table->string('landmark')->nullable();
            $table->string('city')->nullable();
            $table->string('district')->nullable;
            $table->string('address_type')->nullable;
            $table->string('coupon_code')->nullable;
            $table->string('coupon_value')->nullable;
            $table->enum('order_status', ['Ordered','Packed', 'Shipped', 'OFD', 'Delivered', 'Cancel']);
            $table->enum('payment_type', ['online_esewa', 'cashondelivery_cod']);
            $table->string('payment_status');
            $table->string('payment_id')->nullable;
            $table->float('total_amount');
            $table->date('expected_delivery')->nullable();
            $table->enum('cancel_by', ['user', 'admin'])->nullable();
            $table->string('cancel_reason')->nullable();
            $table->longText('addition_reason')->nullable();
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
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
}
