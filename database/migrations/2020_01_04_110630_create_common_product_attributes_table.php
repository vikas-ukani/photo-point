<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommonProductAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('common_product_attributes', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->text('subcategory_ids')->nullable()->index()->comment('multiple category id wise details');
            $table->bigInteger('parent_id')->nullable()->index()->comment('parent of this table id ');
            $table->string('name', 100)->comment('name of this attributes');
            $table->boolean('is_active')->default(true)->comment('check is active to show or not');
            $table->bigInteger('sequence')->default(0)->comment('to set sequence wise');
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
        Schema::dropIfExists('common_product_attributes');
    }
}
