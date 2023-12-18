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
        Schema::create('equipment_machinery_sures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_machinery_id')->constrained();
            $table->string('sure');
            $table->string('taker');
            $table->string('beneficiary');
            $table->date('validity');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_machinery_sures');
    }
};
