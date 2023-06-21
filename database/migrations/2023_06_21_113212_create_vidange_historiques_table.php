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
        Schema::create('vidange_historiques', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('vidange_id');
            $table->foreign('vidange_id')->references('id')->on('vidanges')->onDelete('cascade');

            $table->unsignedBigInteger('current_km');
            $table->unsignedBigInteger('next_km_for_drain');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vidange_historiques');
    }
};
