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
        Schema::table('mission_orders', function (Blueprint $table) {
            $table->string('mission_fr')->nullable();
            $table->string('mission_ar')->nullable();
            $table->dateTime('registration_datetime')->nullable();
            $table->string('place_togo_fr')->nullable();
            $table->string('place_togo_ar')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mission_orders', function (Blueprint $table) {
            $table->dropColumn('mission_fr');
            $table->dropColumn('mission_ar');
            $table->dropColumn('registration_datetime');
            $table->dropColumn('place_togo_fr');
            $table->dropColumn('place_togo_ar');
        });
    }
};
