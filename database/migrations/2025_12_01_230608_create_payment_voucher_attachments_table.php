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
        Schema::create('payment_voucher_attachments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('payment_voucher_id');
            $table->foreign('payment_voucher_id')->references('id')->on('payment_vouchers')->onDelete('cascade');
            $table->enum('document_type', ['voucher', 'invoice', 'vignette', 'other']);
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
        Schema::dropIfExists('payment_voucher_attachments');
    }
};
