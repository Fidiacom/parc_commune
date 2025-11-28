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
        Schema::create('reforme_status_historiques', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reforme_id');
            $table->foreign('reforme_id')->references('id')->on('reformes')->onDelete('cascade');
            $table->enum('status', ['in_progress', 'confirmed', 'rejected', 'selled']);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reforme_status_historiques');
    }
};
