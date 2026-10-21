<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('area_layanan')->nullable();
            $table->string('keahlian')->nullable();
            $table->enum('status_mitra', ['menunggu_verifikasi', 'aktif', 'ditolak'])->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['area_layanan', 'keahlian', 'status_mitra']);
        });
    }
};