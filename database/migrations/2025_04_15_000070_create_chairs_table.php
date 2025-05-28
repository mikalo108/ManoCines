<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('chairs', function (Blueprint $table) {
            $table->id();
            $table->string('row');
            $table->string('column');
            $table->string('state');
            $table->unsignedBigInteger('room_id');
            $table->decimal('price', 8, 2);
            $table->timestamps();
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('chairs');
    }
};
