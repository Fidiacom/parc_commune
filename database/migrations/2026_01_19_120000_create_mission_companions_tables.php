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
        if (!Schema::hasTable('mission_companions')) {
            Schema::create('mission_companions', function (Blueprint $table) {
                $table->id();
                $table->string('first_name_fr')->nullable();
                $table->string('last_name_fr')->nullable();
                $table->string('first_name_ar')->nullable();
                $table->string('last_name_ar')->nullable();
                $table->string('cin')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('mission_order_companion')) {
            Schema::create('mission_order_companion', function (Blueprint $table) {
                $table->id();
                $table->foreignId('mission_order_id')->constrained('mission_orders')->cascadeOnDelete();
                $table->foreignId('mission_companion_id')->constrained('mission_companions')->cascadeOnDelete();
                $table->unique(['mission_order_id', 'mission_companion_id'], 'mission_order_companion_unique');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mission_order_companion');
        Schema::dropIfExists('mission_companions');
    }
};
