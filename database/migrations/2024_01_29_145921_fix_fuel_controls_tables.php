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
        Schema::table('fuel_controls', function (Blueprint $table) {
            $table->dropColumn('measure');
        });

        Schema::table('fuel_control_supplies', function (Blueprint $table) {
            $table->dropForeign(['equipment_machinery_id']);
            $table->dropColumn('equipment_machinery_id');
            $table->dropForeign(['fuel_control_source_id']);
            $table->dropColumn('fuel_control_source_id');
        });

        Schema::table('fuel_control_consumptions', function (Blueprint $table) {
            $table->boolean('is_external_source')->before('date')->nullable();
            $table->foreignId('fuel_control_source_id')->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('fuel_controls', function (Blueprint $table) {
            $table->enum('measure', ['GALONES', 'LITROS'])->default('GALONES');
        });

        Schema::table('fuel_control_supplies', function (Blueprint $table) {
            $table->foreignId('equipment_machinery_id')->nullable()->constrained();
            $table->foreignId('fuel_control_source_id')->nullable()->constrained();
        });

        Schema::table('fuel_control_consumptions', function (Blueprint $table) {
            $table->dropColumn('is_external_source');
            $table->dropForeign(['fuel_control_source_id']);
            $table->dropColumn('fuel_control_source_id');
        });
    }
};
