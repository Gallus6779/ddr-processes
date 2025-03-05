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
        if (!Schema::hasTable('discount_periods')) {
            Schema::create('discount_periods', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('description');
                $table->unsignedBigInteger('district_id');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discount_periods');
    }
};
