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
        Schema::create('stock_historiques', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(App\Models\Stock::class);
            $table->string('type'); //Entre ou sortie
            $table->integer('quantite');

            $table->foreignIdFor(App\Models\Vehicule::class)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_historiques');
    }
};
