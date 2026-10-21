<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('paket_layanans', function (Blueprint $table) {
            $table->enum('kategori', ['rumah', 'kantor', 'spesial'])->default('rumah');
        });
    }

    public function down(): void
    {
        Schema::table('paket_layanans', function (Blueprint $table) {
            $table->dropColumn('kategori');
        });
    }
};