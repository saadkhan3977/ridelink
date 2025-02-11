<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('rides', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('rider_id')->nullable();
            $table->string('nearest_cab')->nullable();
            $table->string('rider_arrived_time')->nullable();
            $table->string('payment_method');
            $table->string('location_from');
            $table->string('location_to');
            $table->string('distance');
            $table->string('date')->nullable();
            $table->string('time')->nullable();
            $table->text('stops')->nullable();
            $table->string('pickup_location_lat');
            $table->string('pickup_location_lng');
            $table->string('dropoff_location_lat');
            $table->string('dropoff_location_lng');
            $table->string('status')->default('pending');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('rider_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('rides');
    }
};
