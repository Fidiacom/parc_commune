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
        Schema::create('pneu_historiques', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pneu_id');
            $table->foreign('pneu_id')->references('id')->on('pneus')->onDelete('cascade');

            $table->unsignedBigInteger('current_km');
            $table->unsignedBigInteger('next_km_for_change');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pneu_historiques');
    }
};
