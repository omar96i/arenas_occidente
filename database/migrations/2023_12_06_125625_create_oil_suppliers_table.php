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
        Schema::create('oil_suppliers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('oil_id')->constrained();
            $table->foreignId('supplier_id')->constrained();
            $table->string('mark');
            $table->double('stock')->nullable();
            $table->double('price')->nullable();
            $table->double('stock_2')->nullable();
            $table->double('price_2')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oil_suppliers');
    }
};
