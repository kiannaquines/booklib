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
        Schema::table('books', function (Blueprint $table) {
            $table->integer('max_slots')->default(25)->after('description');
            $table->integer('reserved_today')->default(0)->after('max_slots');
            $table->date('last_reset_date')->nullable()->after('reserved_today');
        });

        Schema::table('equipments', function (Blueprint $table) {
            $table->integer('max_slots')->default(25)->after('description');
            $table->integer('reserved_today')->default(0)->after('max_slots');
            $table->date('last_reset_date')->nullable()->after('reserved_today');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn(['max_slots', 'reserved_today', 'last_reset_date']);
        });

        Schema::table('equipments', function (Blueprint $table) {
            $table->dropColumn(['max_slots', 'reserved_today', 'last_reset_date']);
        });
    }
};
