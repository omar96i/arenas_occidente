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
        Schema::table('equipment_machinery_fuels', function (Blueprint $table) {
            $table->foreignId('em_fuel_source_id')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('equipment_machinery_fuels', function (Blueprint $table) {
            $table->bigInteger('em_fuel_source_id')->change();
        });
    }
};
