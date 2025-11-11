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
        Schema::table('seat_reservation', function (Blueprint $table) {
            $table->dateTime('start_time')->after('reason')->nullable();
            $table->dateTime('end_time')->after('start_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seat_reservation', function (Blueprint $table) {
            $table->dropColumn(['start_time', 'end_time']);
        });
    }
};
