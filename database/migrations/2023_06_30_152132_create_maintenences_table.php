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
        Schema::create('maintenences', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(App\Models\Stock::class);
            $table->foreignIdFor(App\Models\Vehicule::class);
            $table->decimal('qte_sortie');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenences');
    }
};
