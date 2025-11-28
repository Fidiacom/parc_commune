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
        Schema::create('payment_vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('voucher_number')->unique();
            $table->string('invoice_number')->nullable();
            $table->date('invoice_date');
            $table->decimal('amount', 10, 2);
            $table->unsignedBigInteger('vehicule_id');
            $table->foreign('vehicule_id')->references('id')->on('vehicules')->onDelete('CASCADE');
            $table->integer('vehicle_km');
            $table->string('document_path')->nullable();
            $table->text('additional_info')->nullable();
            $table->string('supplier')->nullable();
            $table->enum('category', [
                'carburant',
                'entretien',
                'lavage',
                'lubrifiant',
                'reparation',
                'achat_pieces_recharges',
                'rechange_pneu',
                'frais_immatriculation',
                'visite_technique'
            ]);
            
            // Special fields for different categories
            $table->decimal('fuel_liters', 10, 2)->nullable(); // For carburant
            $table->unsignedBigInteger('tire_id')->nullable(); // For rechange_pneu
            $table->foreign('tire_id')->references('id')->on('pneus')->onDelete('SET NULL');
            $table->unsignedBigInteger('vidange_id')->nullable(); // For entretien (vidange)
            $table->foreign('vidange_id')->references('id')->on('vidanges')->onDelete('SET NULL');
            $table->unsignedBigInteger('timing_chaine_id')->nullable(); // For entretien (timing chaine)
            $table->foreign('timing_chaine_id')->references('id')->on('timing_chaines')->onDelete('SET NULL');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_vouchers');
    }
};
