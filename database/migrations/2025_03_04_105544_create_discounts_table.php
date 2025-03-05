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
        if (!Schema::hasTable('discounts')) {
            Schema::create('discounts', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('customer_id');
                $table->unsignedBigInteger('card_id');
                $table->unsignedBigInteger('period_discount_id');
                $table->unsignedBigInteger('district_id');
                $table->decimal('volume_caculated');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};
