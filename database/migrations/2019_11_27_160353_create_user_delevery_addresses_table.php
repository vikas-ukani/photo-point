<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDeleveryAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_delevery_addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->nullable()->comment("User address id");
            $table->string('name', 50)->nullable()->comment("User Delevery name");
            $table->string('mobile', 20)->nullable()->comment("User mobile");
            $table->string('alternate_mobile', 25)->nullable()->comment('Alter mobile ');
            $table->integer('pincode')->nullable();
            $table->string('line1', 100)->nullable()->comment("address line 1");
            $table->string('line2', 100)->nullable()->comment("address line 2");
            $table->bigInteger('country_id')->nullable()->comment("Country id");
            $table->bigInteger('state_id')->nullable();
            $table->bigInteger('city_id')->nullable();
            $table->boolean('is_default')->default(false)->comment("default delevery address");
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
        Schema::dropIfExists('user_delevery_addresses');
    }
}
