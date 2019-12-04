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
            $table->bigIncrements('id');
            $table->bigInteger('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('main_categories');
            $table->string('name')->comment('Product Name');
            $table->text('image')->nullable();
            $table->float('price');
            $table->text('size', 50)->comment("Multiple Sizes.");
            $table->text('size_number', 50)->comment("numeric size number.");
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true)->comment("product is active or not.");
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
