<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            $table->text('checklist_selesai')->nullable();
        });

        Schema::table('komplains', function (Blueprint $table) {
            $table->string('jenis_masalah')->default('lainnya');
        });
    }

    public function down(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            $table->dropColumn('checklist_selesai');
        });

        Schema::table('komplains', function (Blueprint $table) {
            $table->dropColumn('jenis_masalah');
        });
    }
};
