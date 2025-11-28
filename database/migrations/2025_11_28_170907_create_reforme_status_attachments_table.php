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
        Schema::create('reforme_status_attachments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reforme_status_historique_id');
            $table->foreign('reforme_status_historique_id')->references('id')->on('reforme_status_historiques')->onDelete('cascade');
            $table->string('file_path');
            $table->string('file_name')->nullable();
            $table->string('file_type')->nullable();
            $table->unsignedBigInteger('file_size')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reforme_status_attachments');
    }
};
