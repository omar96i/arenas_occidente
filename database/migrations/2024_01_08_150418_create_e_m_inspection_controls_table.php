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
        Schema::create('e_m_inspection_controls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_machinery_id')->constrained();
            $table->date('last_report')->nullable();
            $table->date('actual_report')->nullable();
            $table->date('next_report')->nullable();
            $table->double('hourometer')->nullable();
            $table->integer('frequency');
            $table->string('unit');
            $table->string('status');
            $table->date('extinguisher_expiration')->nullable();
            $table->string('extinguisher_status')->nullable();
            $table->string('installed_board')->nullable();
            $table->string('installed_board_id')->nullable();
            $table->string('installed_board_status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('e_m_inspection_controls');
    }
};
