<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal_mitras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mitra_id')->constrained('users')->cascadeOnDelete();
            $table->enum('hari', ['senin','selasa','rabu','kamis','jumat','sabtu','minggu']);
            $table->boolean('tersedia')->default(false);
            $table->timestamps();
            $table->unique(['mitra_id', 'hari']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_mitras');
    }
};