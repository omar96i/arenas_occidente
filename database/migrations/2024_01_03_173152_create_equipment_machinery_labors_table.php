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
        Schema::create('equipment_machinery_labors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_machinery_id')->constrained();
            $table->date('date');
            $table->time('entry_time')->nullable();
            $table->time('departure_time')->nullable();
            $table->enum('status', ['DISPONIBLE', 'TRABAJO'])->default('TRABAJO');
            $table->foreignId('user_id')->constrained(); //conductor
            $table->string('location');
            $table->foreignId('entity_id')->constrained(); //contrato o entidad (cliente)
            $table->string('activity');
            $table->string('hr_ini');
            $table->string('hr_fin');
            $table->string('hr_lab');
            $table->string('trips');
            $table->string('ton')->nullable();
            $table->string('state_fact')->nullable();
            $table->string('observations')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_machinery_labors');
    }
};
