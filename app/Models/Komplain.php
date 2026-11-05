<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Komplain extends Model
{
    public const JENIS = [
        'pembayaran' => 'Pembayaran',
        'kualitas' => 'Kualitas pekerjaan',
        'keterlambatan' => 'Keterlambatan',
        'perilaku_mitra' => 'Perilaku mitra',
        'lainnya' => 'Lainnya',
    ];

    protected $fillable = [
        'pesanan_id',
        'pelanggan_id',
        'jenis_masalah',
        'deskripsi',
        'foto_bukti',
        'status',
        'tanggapan_admin',
    ];

    public function pesanan(): BelongsTo
    {
        return $this->belongsTo(Pesanan::class);
    }

    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pelanggan_id');
    }
}
