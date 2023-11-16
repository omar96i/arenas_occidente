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
        Schema::create('equipment_machinery_maintenances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_machinery_id')->constrained();
            $table->string('code');
            $table->date('entry_date');
            $table->date('exit_date')->nullable();
            $table->float('measure');
            $table->float('estimated_time');
            $table->float('real_time');
            $table->string('driver')->nullable();
            $table->enum('maintenance_type', ['preventivo','correctivo']);
            $table->json('activities');
            $table->text('other_activities')->nullable();
            $table->text('welding_activities')->nullable(); //soldadura
            $table->text('description_corrective_maintenance')->nullable();
            $table->string('elaborated_signature')->nullable();
            $table->string('revised_signature')->nullable();
            $table->timestamps();		
        });
        Schema::enableForeignKeyConstraints();    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_machinery_maintenances');
    }
};
