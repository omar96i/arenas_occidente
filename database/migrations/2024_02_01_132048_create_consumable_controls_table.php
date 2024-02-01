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
        Schema::create('consumable_controls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consumable_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('equipment_machinery_id')->constrained();
            $table->double('amount');
            $table->date('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consumable_controls');
    }
};
