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
        Schema::table('maintenance_schedulings', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained();
            $table->string('mileage')->nullable();
            $table->string('hourometer')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('maintenance_schedulings', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::table('maintenance_schedulings', function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->dropColumn('mileage');
            $table->dropColumn('hourometer');
        });
    }
};
