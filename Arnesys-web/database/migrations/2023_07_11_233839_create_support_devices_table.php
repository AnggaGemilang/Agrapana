<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupportDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('support_devices', function (Blueprint $table) {
            $table->id();
            $table->integer('number_of');
            $table->double('soil_temperature');
            $table->integer('soil_humidity');
            $table->integer('soil_ph');
            $table->double('soil_nitrogen');
            $table->double('soil_phosphor');
            $table->double('soil_kalium');
            $table->integer('main_device_id');
            $table->index('main_device_id')->references('id')->on('main_device')->onDelete('cascade');
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
        Schema::dropIfExists('support_devices');
    }
}
