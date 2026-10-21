<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            $table->integer('komisi_platform')->default(0)->after('total_tagihan');
            $table->integer('pendapatan_mitra')->default(0)->after('komisi_platform');
        });
    }

    public function down(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            $table->dropColumn(['komisi_platform', 'pendapatan_mitra']);
        });
    }
};