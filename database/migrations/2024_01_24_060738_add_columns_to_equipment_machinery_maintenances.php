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
        Schema::table('equipment_machinery_maintenances', function (Blueprint $table) {
            $table->text('file_evidence')->after('revised_signature'); // evidencia
            $table->string('invoice_number')->after('file_evidence'); //factura
            $table->json('parts_amount_value')->after('invoice_number'); //json repuestos, cantidad, valor
            $table->float('labor_value')->after('parts_amount_value'); //valor mano de obra
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('equipment_machinery_maintenances', function (Blueprint $table) {
            $table->dropColumn('labor_value');
            $table->dropColumn('parts_amount_value');
            $table->dropColumn('invoice_number');
            $table->dropColumn('file_evidence');
        });
    }
};
