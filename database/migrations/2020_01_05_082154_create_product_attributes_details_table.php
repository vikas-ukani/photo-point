<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductAttributesDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_attributes_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('product_id')->comment('Product Filter Ids');
            $table->bigInteger('common_product_attribute_id')->comment('common attribute id');
            $table->string('value', 200)->nullable()->comment('common attribute id value');
            $table->text('values')->nullable()->comment('multiple common attribute id values.'); // store a [id,value]; => id=> commonAttId, value=>commonAttId value

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
        Schema::dropIfExists('product_attributes_details');
    }
}
