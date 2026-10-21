<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $dari = $request->query('dari') ? Carbon::parse($request->query('dari'))->startOfDay() : now()->startOfMonth();
        $sampai = $request->query('sampai') ? Carbon::parse($request->query('sampai'))->endOfDay() : now()->endOfDay();

        $pesananSelesai = Pesanan::where('status', 'selesai')
            ->whereBetween('updated_at', [$dari, $sampai])
            ->with(['pelanggan', 'paketLayanan'])
            ->latest('updated_at')
            ->get();

        $totalTransaksi = $pesananSelesai->sum('total_tagihan');
        $totalKomisiPlatform = $pesananSelesai->sum('komisi_platform');
        $totalPesanan = $pesananSelesai->count();
        $rataRata = $totalPesanan > 0 ? intdiv($totalTransaksi, $totalPesanan) : 0;

        $bulanData = [];
        for ($i = 5; $i >= 0; $i--) {
            $bulan = now()->copy()->subMonths($i);
            $total = Pesanan::where('status', 'selesai')
                ->whereYear('updated_at', $bulan->year)
                ->whereMonth('updated_at', $bulan->month)
                ->sum('komisi_platform');

            $bulanData[] = [
                'label' => $bulan->translatedFormat('M Y'),
                'total' => $total,
            ];
        }

        $grafikLabel = array_column($bulanData, 'label');
        $grafikData = array_column($bulanData, 'total');

        return view('laporan.index', compact(
            'pesananSelesai', 'totalTransaksi', 'totalKomisiPlatform', 'totalPesanan', 'rataRata', 'dari', 'sampai', 'grafikLabel', 'grafikData', 'bulanData'
        ));
    }
}