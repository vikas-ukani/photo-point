<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned()->comment('which user cart');
            $table->foreign('user_id')->references('id')->on('user');

            $table->bigInteger('product_id')->unsigned()->comment('which product on cart');
            $table->foreign('product_id')->references('id')->on('products');
            $table->bigInteger('quantity')->default(1)->comment("How many product added in to cart");

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
        Schema::dropIfExists('carts');
    }
}
