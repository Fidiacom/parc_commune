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
            $table->decimal('min_fuel_consumption_hour', 8, 2)->nullable()->after('max_fuel_consumption_100km');
            $table->decimal('max_fuel_consumption_hour', 8, 2)->nullable()->after('min_fuel_consumption_hour');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicules', function (Blueprint $table) {
            $table->dropColumn(['min_fuel_consumption_hour', 'max_fuel_consumption_hour']);
        });
    }
};
