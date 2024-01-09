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
        Schema::create('equipment_machinery_fuels', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->foreignId('equipment_machinery_id')->constrained();
            $table->integer('acpm');
            $table->integer('horom_tanq');
            $table->string('source'); // fuente de tanqueo
            $table->string('consecutive_ing')->nullable();
            $table->text('file_img')->nullable();
            $table->foreignId('user_id')->constrained(); //responsable?
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_machinery_fuels');
    }
};
