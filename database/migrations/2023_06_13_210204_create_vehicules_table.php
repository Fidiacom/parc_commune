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
        Schema::create('vehicules', function (Blueprint $table) {
            $table->id();
            $table->string('brand');
            $table->text('image')->nullable();
            $table->string('model');
            $table->string('matricule');
            $table->string('num_chassis');
            $table->unsignedBigInteger('total_km');
            $table->integer('horses');
            $table->integer('number_of_tires');
            $table->string('fuel_type');
            $table->boolean('airbag');
            $table->boolean('abs');
            $table->date('inssurance_expiration');
            $table->date('technicalvisite_expiration');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicules');
    }
};
