<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductStockInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_stock_inventories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('product_id')->unsigned()->index()->comment("Product Stock Manager");
            $table->foreign('product_id')->references('id')->on('products');

            $table->bigInteger('common_product_attribute_size_id')->unsigned()->index()->comment("common product size attributes");
            $table->foreign('common_product_attribute_size_id')->references('id')->on('common_product_attributes');

            $table->bigInteger('common_product_attribute_color_id')->unsigned()->index()->comment("common product color attributes");
            $table->foreign('common_product_attribute_color_id')->references('id')->on('common_product_attributes');

            $table->string('images', 200)->nullable()->comment('stock wise images');

            $table->integer('sale_price')->comment("selling price");
            $table->integer('mrp_price')->comment("MRP price");
            $table->integer('stock_available')->comment("number of items available");

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
        Schema::dropIfExists('product_stock_inventories');
    }
}
