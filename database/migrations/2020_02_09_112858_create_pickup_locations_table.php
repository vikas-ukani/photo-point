<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePickupLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pickup_locations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->comment('user address');
            $table->string('pickup_location', 200);
            $table->string('name', 200);
            $table->string('email', 200);
            $table->string('phone', 200);
            $table->string('address', 200);
            $table->string('address_2', 200)->nullable();
            $table->string('city', 200);
            $table->string('state', 200);
            $table->string('country', 200);
            $table->string('pin_code', 200);
            $table->boolean('is_active')->default(true);
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
        Schema::dropIfExists('pickup_locations');
    }
}
