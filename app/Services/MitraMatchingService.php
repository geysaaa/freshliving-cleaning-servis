<?php

namespace App\Services;

use App\Models\JadwalMitra;
use App\Models\Pesanan;
use App\Models\User;

class MitraMatchingService
{
    private array $hariMap = [
        0 => 'minggu', 1 => 'senin', 2 => 'selasa', 3 => 'rabu',
        4 => 'kamis', 5 => 'jumat', 6 => 'sabtu',
    ];

    public function carikanMitra(Pesanan $pesanan): ?User
    {
        $hariJadwal = $this->hariMap[$pesanan->jadwal->dayOfWeek];

        $kandidat = User::where('role', 'mitra')
            ->where('status_mitra', 'aktif')
            ->whereHas('jadwalMitras', function ($q) use ($hariJadwal) {
                $q->where('hari', $hariJadwal)->where('tersedia', true);
            })
            ->inRandomOrder()
            ->get();

        if ($kandidat->isEmpty()) {
            $kandidat = User::where('role', 'mitra')
                ->where('status_mitra', 'aktif')
                ->inRandomOrder()
                ->get();
        }

        foreach ($kandidat as $mitra) {
            $bentrok = Pesanan::where('mitra_id', $mitra->id)
                ->whereNotIn('status', ['selesai', 'dibatalkan'])
                ->whereBetween('jadwal', [
                    $pesanan->jadwal->copy()->subHours(2),
                    $pesanan->jadwal->copy()->addHours(2),
                ])
                ->exists();

            if (!$bentrok) {
                return $mitra;
            }
        }

        return null;
    }
}