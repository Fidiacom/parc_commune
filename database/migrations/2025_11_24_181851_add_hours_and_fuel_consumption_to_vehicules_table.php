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
        Schema::table('vehicules', function (Blueprint $table) {
            $table->unsignedBigInteger('total_hours')->nullable()->after('total_km');
            $table->decimal('min_fuel_consumption_100km', 8, 2)->nullable()->after('fuel_type');
            $table->decimal('max_fuel_consumption_100km', 8, 2)->nullable()->after('min_fuel_consumption_100km');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicules', function (Blueprint $table) {
            $table->dropColumn(['total_hours', 'min_fuel_consumption_100km', 'max_fuel_consumption_100km']);
        });
    }
};
