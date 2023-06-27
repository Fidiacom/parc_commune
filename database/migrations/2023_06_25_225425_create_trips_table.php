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
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('driver_id')->nullable();
            $table->foreign('driver_id')->references('id')->on('drivers')->onDelete('SET NULL');

            $table->unsignedBigInteger('vehicule_id')->nullable();
            $table->foreign('vehicule_id')->references('id')->on('vehicules')->onDelete('SET NULL');

            $table->boolean('permanent');
            $table->date('start');
            $table->date('end')->nullable();

            $table->date('done_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
