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
        Schema::table('oil_controls', function (Blueprint $table) {
            $table->date('date')->nullable();
            $table->string('area')->nullable();
            $table->string('amount')->change();
            $table->dropColumn('cost_per_gallon');
            $table->dropColumn('cost_total');
            $table->dropColumn('month');
            $table->dropColumn('year');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('oil_controls', function (Blueprint $table) {
            $table->string('month')->nullable();
            $table->string('year')->nullable();
            $table->double('amount')->nullable();
            $table->double('cost_per_gallon')->nullable();
            $table->double('cost_total')->nullable();
            $table->dropColumn('date');
            $table->dropColumn('area');
            $table->dropColumn('amount');

        });
    }
};
