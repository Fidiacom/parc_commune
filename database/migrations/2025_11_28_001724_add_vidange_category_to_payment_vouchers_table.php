<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Modify the enum to add 'vidange' category
        DB::statement("ALTER TABLE payment_vouchers MODIFY COLUMN category ENUM(
            'carburant',
            'entretien',
            'lavage',
            'lubrifiant',
            'reparation',
            'achat_pieces_recharges',
            'rechange_pneu',
            'frais_immatriculation',
            'visite_technique',
            'insurance',
            'other',
            'vidange'
        )");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to previous enum values
        DB::statement("ALTER TABLE payment_vouchers MODIFY COLUMN category ENUM(
            'carburant',
            'entretien',
            'lavage',
            'lubrifiant',
            'reparation',
            'achat_pieces_recharges',
            'rechange_pneu',
            'frais_immatriculation',
            'visite_technique',
            'insurance',
            'other'
        )");
    }
};
