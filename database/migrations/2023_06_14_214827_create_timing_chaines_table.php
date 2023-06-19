<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('timing_chaines', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('car_id');
            $table->foreign('car_id')->references('id')->on('vehicules')->onDelete('cascade');

            $table->unsignedBigInteger('current_km');
            $table->unsignedBigInteger('next_km_for_change');
            $table->unsignedBigInteger('threshold_km');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timing_chaines');
    }
};
