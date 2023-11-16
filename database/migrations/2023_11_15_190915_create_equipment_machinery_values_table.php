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
        Schema::create('equipment_machinery_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_machinery_id')->constrained();
            $table->foreignId('equipment_machinery_option_id')->constrained('equipment_machinery_options');
            $table->string('value');
            $table->timestamps();
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_machinery_values');
    }
};
