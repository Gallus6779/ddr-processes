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
            if (!Schema::hasColumn('discounts', 'amount')) {
                $table->decimal('amount', 10, 2)->default(0);
            }

            // Vérifier aussi pour les autres colonnes utilisées
            if (!Schema::hasColumn('discounts', 'status')) {
                $table->string('status')->default('pending');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('discounts', function (Blueprint $table) {
            if (Schema::hasColumn('discounts', 'amount')) {
                $table->dropColumn('amount');
            }

            if (Schema::hasColumn('discounts', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
