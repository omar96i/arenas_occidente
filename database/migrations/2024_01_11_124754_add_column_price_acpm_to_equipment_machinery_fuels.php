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
            $table->float('price_acpm', 15,2)->nullable()->after('acpm');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('equipment_machinery_fuels', function (Blueprint $table) {
            $table->dropColumn('price_acpm');
        });
    }
};
