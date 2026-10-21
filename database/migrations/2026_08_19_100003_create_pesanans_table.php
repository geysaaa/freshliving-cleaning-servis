<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelanggan_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('paket_layanan_id')->constrained('paket_layanans');
            $table->foreignId('mitra_id')->nullable()->constrained('users');
            $table->string('alamat');
            $table->text('catatan_tambahan')->nullable();
            $table->dateTime('jadwal');
            $table->enum('status', [
                'menunggu_mitra', 'dikonfirmasi', 'menuju_lokasi',
                'sedang_mengerjakan', 'selesai', 'dibatalkan',
            ])->default('menunggu_mitra');
            $table->integer('total_tagihan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};