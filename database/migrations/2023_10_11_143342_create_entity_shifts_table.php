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
        Schema::disableForeignKeyConstraints();
        Schema::create('entity_shifts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entity_segment_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('entity_measure_id')->constrained();
            $table->date('date');
            $table->timestamps();
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entity_shifts');
    }
};
