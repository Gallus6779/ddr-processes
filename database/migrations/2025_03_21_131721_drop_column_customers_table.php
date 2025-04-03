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
        Schema::table('customers', function (Blueprint $table) {
            $table->char('deleted_yn')->default('N');

            if (Schema::hasColumn('customers', 'firstname')) {
                $table->dropColumn('firstname');
            }
            if (Schema::hasColumn('customers', 'lastname')) {
                $table->dropColumn('lastname');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('deleted_yn');
        });
    }
};
