<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaketLayanan extends Model
{
    public const SOP_SEBELUM = [
        'Memperkenalkan diri dan mengonfirmasi alamat serta kebutuhan ke pelanggan',
        'Mengecek kondisi area yang akan dibersihkan',
        'Menyiapkan peralatan dan bahan pembersih',
        'Mengamankan barang berharga atau mudah pecah',
    ];

    public const SOP_SESUDAH = [
        'Memeriksa ulang seluruh area yang sudah dibersihkan',
        'Merapikan kembali perabot ke posisi semula',
        'Membuang sampah hasil pembersihan',
        'Meminta pelanggan memeriksa hasil pekerjaan',
    ];

    protected $fillable = [
        'nama_paket',
        'deskripsi',
        'detail_layanan',
        'harga',
        'estimasi_durasi_menit',
        'aktif',
        'kategori',
    ];

    public function pesanans(): HasMany
    {
        return $this->hasMany(Pesanan::class);
    }

    /** Item pekerjaan dari kolom Detail Layanan (satu baris = satu item). */
    public function itemDetail(): array
    {
        if (!$this->detail_layanan) {
            return [];
        }

        $baris = array_map('trim', preg_split('/\R/', $this->detail_layanan));

        return array_values(array_filter($baris, fn ($item) => $item !== ''));
    }

    /** Tiga kelompok checklist: SOP sebelum, pekerjaan, SOP sesudah. */
    public function grupChecklist(): array
    {
        return [
            'sebelum' => ['judul' => 'SOP Sebelum Pekerjaan (Before)', 'ikon' => 'bi-play-circle', 'items' => self::SOP_SEBELUM],
            'kerja' => ['judul' => 'Pekerjaan yang Dikerjakan', 'ikon' => 'bi-tools', 'items' => $this->itemDetail()],
            'sesudah' => ['judul' => 'SOP Setelah Pekerjaan (After)', 'ikon' => 'bi-check2-circle', 'items' => self::SOP_SESUDAH],
        ];
    }

    /** Semua kunci item, bentuknya "kelompok:nomor", misalnya "sebelum:0". */
    public function semuaKunciChecklist(): array
    {
        $kunci = [];

        foreach ($this->grupChecklist() as $kode => $grup) {
            foreach (array_keys($grup['items']) as $i) {
                $kunci[] = $kode . ':' . $i;
            }
        }

        return $kunci;
    }
}
