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
        Schema::table('discounts', function (Blueprint $table) {
            // Vérifier si la colonne existe déjà avant de l'ajouter
            if (!Schema::hasColumn('discounts', 'consumption_id')) {
                $table->foreignId('consumption_id')->nullable()->constrained('consumptions')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('discounts', function (Blueprint $table) {
            if (Schema::hasColumn('discounts', 'consumption_id')) {
                $table->dropForeign(['consumption_id']);
                $table->dropColumn('consumption_id');
            }
        });
    }
};
