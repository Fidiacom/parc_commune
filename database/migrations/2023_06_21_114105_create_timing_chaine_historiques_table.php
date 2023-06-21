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
        Schema::create('timing_chaine_historiques', function (Blueprint $table) {
            $table->id();


            $table->unsignedBigInteger('chaine_id');
            $table->foreign('chaine_id')->references('id')->on('timing_chaines')->onDelete('cascade');

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
        Schema::dropIfExists('timing_chaine_historiques');
    }
};
