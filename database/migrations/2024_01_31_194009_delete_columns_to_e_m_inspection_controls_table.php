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
        Schema::table('e_m_inspection_controls', function (Blueprint $table) {
            $table->dropColumn('installed_board');
            $table->dropColumn('installed_board_id');
            $table->dropColumn('installed_board_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('e_m_inspection_controls', function (Blueprint $table) {
            $table->string('installed_board')->nullable();
            $table->string('installed_board_id')->nullable();
            $table->string('installed_board_status')->nullable();
        });
    }
};
