<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pesanan extends Model
{
    protected $fillable = [
        'pelanggan_id',
        'paket_layanan_id',
        'mitra_id',
        'alamat',
        'catatan_tambahan',
        'jadwal',
        'status',
        'total_tagihan',
        'komisi_platform',
        'pendapatan_mitra',
        'status_pembayaran',
        'bukti_transfer',
        'metode_pembayaran',
    ];

    protected $casts = [
        'jadwal' => 'datetime',
    ];

    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pelanggan_id');
    }

    public function mitra(): BelongsTo
    {
        return $this->belongsTo(User::class, 'mitra_id');
    }

    public function paketLayanan(): BelongsTo
    {
        return $this->belongsTo(PaketLayanan::class);
    }

    public function rating(): HasOne
    {
        return $this->hasOne(Rating::class);
    }
}