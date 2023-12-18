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
        Schema::create('oil_controls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('oil_id')->constrained();
            $table->foreignId('equipment_machinery_id')->constrained();
            $table->string('month')->nullable();
            $table->string('year')->nullable();
            $table->double('amount')->nullable();
            $table->double('cost_per_gallon')->nullable();
            $table->double('cost_total')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oil_controls');
    }
};
