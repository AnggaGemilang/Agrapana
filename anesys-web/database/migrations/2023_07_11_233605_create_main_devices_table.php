<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMainDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('main_devices', function (Blueprint $table) {
            $table->id();
            $table->double('wind_temperature');
            $table->integer('wind_humidity');
            $table->double('wind_pressure');
            $table->double('wind_speed');
            $table->boolean('rainfall');
            $table->integer('user_id');
            $table->index('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('main_devices');
    }
}
