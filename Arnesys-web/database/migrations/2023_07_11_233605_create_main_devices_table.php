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
            $table->string('address', 255);
            $table->string('plant_type', 50);
            $table->string('thumbnail', 255)->nullable();
            $table->integer('number_of_support_devices');
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
