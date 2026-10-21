<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaketLayanan extends Model
{
    protected $fillable = [
        'nama_paket', 'deskripsi', 'detail_layanan', 'harga', 'estimasi_durasi_menit', 'aktif', 'kategori',
    ];

    public function pesanans(): HasMany
    {
        return $this->hasMany(Pesanan::class);
    }
}