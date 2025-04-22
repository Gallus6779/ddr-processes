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
        if (!Schema::hasTable('consumptions')) {
            Schema::create('consumptions', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('customer_id');
                $table->unsignedBigInteger('card_id');
                $table->unsignedBigInteger('wallet_id');
                $table->decimal('quantity');
                $table->datetime('date_consumption');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consumptions');
    }
};
