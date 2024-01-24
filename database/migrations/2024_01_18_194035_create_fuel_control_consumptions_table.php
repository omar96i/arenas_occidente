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
        Schema::create('fuel_control_consumptions', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->foreignId('fuel_control_id')->nullable()->constrained(); //origen
            $table->foreignId('equipment_machinery_id')->nullable()->constrained(); // destino
            $table->integer('horom_tanq');
            $table->foreignId('user_id')->constrained(); //responsable
            $table->float('amount', 15,2); //cantidad
            $table->enum('measure', ['GALONES', 'LITROS'])->default('GALONES'); //medida
            $table->float('price', 15,2); // precio
            $table->text('file_evidence')->nullable(); //evidencia
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fuel_control_consumptions');
    }
};
