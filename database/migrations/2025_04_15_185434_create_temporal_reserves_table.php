<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('temporal_reserves', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('chair_id');
            $table->timestamp('reserve_time');
            $table->timestamps();
            $table->foreign('chair_id')->references('id')->on('chairs');
        });
    }

    public function down()
    {
        Schema::dropIfExists('temporal_reserves');
    }
};
