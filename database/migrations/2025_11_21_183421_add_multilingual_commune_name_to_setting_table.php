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
        Schema::table('setting', function (Blueprint $table) {
            $table->string('commune_name_fr')->nullable()->after('commune_name');
            $table->string('commune_name_ar')->nullable()->after('commune_name_fr');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('setting', function (Blueprint $table) {
            $table->dropColumn(['commune_name_fr', 'commune_name_ar']);
        });
    }
};
