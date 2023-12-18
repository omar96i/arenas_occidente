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
        Schema::create('equipment_machinary_technos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_machinery_id')->constrained();
            $table->string('technomechanical');
            $table->date('date_tuition');
            $table->date('last_revision');
            $table->date('date_revision');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_machinary_technos');
    }
};
