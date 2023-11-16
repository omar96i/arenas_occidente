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
        Schema::create('equipment_machinery_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_machinery_categories_id')->constrained()
                ->constrained()
                ->name('fk_options_categories'); //solucion a error de foranea por la logitud del nombre
            $table->string('name');
            $table->timestamps();
        });
        Schema::enableForeignKeyConstraints();    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_machinery_options');
    }
};
