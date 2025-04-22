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
        Schema::table('districts', function (Blueprint $table) {
            $table->string('acronym');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('validated_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('districts', function (Blueprint $table) {
            $table->dropColumn('acronym');
            $table->dropColumn('created_by');
            $table->dropColumn('validated_by');
        });
    }
};
