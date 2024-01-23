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
        Schema::table('oil_suppliers', function (Blueprint $table) {
            $table->string('file')->nullable();
            $table->dropColumn('stock_2');
            $table->dropColumn('price_2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('oil_suppliers', function (Blueprint $table) {
            $table->double('stock_2')->nullable();
            $table->double('price_2')->nullable();
            $table->dropColumn('file');
        });
    }
};
