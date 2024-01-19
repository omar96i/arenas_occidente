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
        // Primero, eliminamos la restricción de clave externa
        Schema::table('entity_shifts', function (Blueprint $table) {
            $table->dropForeign(['entity_measure_id']);
        });

        // Luego, eliminamos la columna
        Schema::table('entity_shifts', function (Blueprint $table) {
            $table->dropColumn('entity_measure_id');
            $table->string('schedule')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('entity_shifts', function (Blueprint $table) {
            $table->foreignId('entity_measure_id')->constrained();
            $table->dropColumn('schedule');
        });
    }
};
