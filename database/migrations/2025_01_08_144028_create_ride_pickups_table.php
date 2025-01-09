<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ride_pickups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ride_id');
            $table->string('pickup_lat')->nullable();
			$table->string('pickup_lng')->nullable();
            $table->string('drop_lat')->nullable();
			$table->string('drop_lng')->nullable();
            $table->timestamps();
            $table->foreign('ride_id')->references('id')->on('rides')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ride_pickups');
    }
};
