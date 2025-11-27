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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->text('image')->nullable();
            $table->string('first_name_ar')->nullable();
            $table->string('first_name_fr')->nullable();
            $table->string('last_name_ar')->nullable();
            $table->string('last_name_fr')->nullable();
            $table->string('role_ar')->nullable();
            $table->string('role_fr')->nullable();
            $table->string('cin')->nullable();
            $table->string('phone')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
