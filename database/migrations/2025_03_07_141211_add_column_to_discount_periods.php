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
        Schema::table('discount_periods', function (Blueprint $table) {
            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('validated_by');
            $table->string('description')->nullable()->change();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('discount_periods', function (Blueprint $table) {
            $table->dropColumn('start_date');
            $table->dropColumn('end_date');
            $table->dropColumn('created_by');
            $table->dropColumn('validated_by');
            $table->string('description')->nullable(false)->change();
        });
    }
};
