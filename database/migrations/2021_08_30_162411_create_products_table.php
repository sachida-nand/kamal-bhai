<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->integer('status')->comment('0 for deactive 1 for published 2 for unpublished');
            $table->bigInteger('catagorie_id')->unsigned();
            $table->bigInteger('brand_id')->nullable()->unsigned();
            $table->string('product_name');
            $table->integer('minimum_purchage_qty');
            $table->string('barcode')->nullable();
            $table->integer('refund_day')->nullable();
            $table->string('video_link')->nullable();
            $table->double('unit_price');
            $table->double('discout')->nullable();
            $table->enum('discount_type', ['flat', 'percentage'])->nullable();
            $table->double('discounted_price')->nullable();
            $table->double('quantity');
            $table->bigInteger('product_sold')->nullable();
            $table->longText('product_description')->nullable();
            $table->longText('product_short_description')->nullable();
            $table->text('tags')->nullable()->comment('tags for serching purpose');
            $table->longText('meta_description')->nullable();
            $table->string('sku');
            $table->enum('free_shipping', ['yes', 'no']);
            $table->double('shipping_cost')->nullable();
            $table->enum('is_qty_mply', ['yes','no'])->nullable();
            $table->integer('stock_warnning');
            $table->enum('cash_on_delivery', ['yes', 'no']);
            $table->enum('is_featured', ['yes', 'no']);
            $table->enum('today_deal', ['yes', 'no']);
            $table->dateTime('today_deal_end')->nullable();
            $table->integer('est_shipping_time')->nullable();
            $table->enum('is_trending', ['yes', 'no']);
            $table->foreign('catagorie_id')
            ->references('id')
                ->on('catagories')
                ->onDelete('cascade');
            $table->foreign('brand_id')
                ->references('id')
                ->on('brands')
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
        Schema::dropIfExists('products');
    }
}
