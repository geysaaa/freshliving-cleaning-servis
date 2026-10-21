<?php

namespace App\Http\Controllers;

use App\Models\Komplain;
use App\Models\PaketLayanan;
use App\Models\Pesanan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $dari = $request->query('dari') ? Carbon::parse($request->query('dari'))->startOfDay() : now()->startOfMonth();
        $sampai = $request->query('sampai') ? Carbon::parse($request->query('sampai'))->endOfDay() : now()->endOfDay();

        // Rule 2: Kartu KPI
        $totalPaket = PaketLayanan::count();
        $menungguMitra = Pesanan::where('status', 'menunggu_mitra')->count();
        $sedangDikerjakan = Pesanan::where('status', 'sedang_mengerjakan')->count();
        $selesai = Pesanan::where('status', 'selesai')->count();

        // Rule 3: Grafik utama - komisi platform per hari dalam rentang filter
        $grafikLabel = [];
        $grafikData = [];
        $cursor = $dari->copy();
        while ($cursor->lte($sampai)) {
            $total = Pesanan::where('status', 'selesai')
                ->whereDate('updated_at', $cursor->toDateString())
                ->sum('komisi_platform');
            $grafikLabel[] = $cursor->translatedFormat('d M');
            $grafikData[] = $total;
            $cursor->addDay();
        }

        // Rule 4: Detail - pesanan terbaru & breakdown kategori
        $pesananTerbaru = Pesanan::with(['pelanggan', 'paketLayanan'])->latest()->take(5)->get();

        $breakdownKategori = Pesanan::whereBetween('pesanans.created_at', [$dari, $sampai])
            ->join('paket_layanans', 'pesanans.paket_layanan_id', '=', 'paket_layanans.id')
            ->selectRaw('paket_layanans.kategori, count(*) as jumlah')
            ->groupBy('paket_layanans.kategori')
            ->pluck('jumlah', 'kategori');

        // Rule 5: Catatan aksi - insight yang butuh perhatian admin
        $pesananLamaMenunggu = Pesanan::where('status', 'menunggu_mitra')
            ->where('created_at', '<=', now()->subHours(24))
            ->count();
        $mitraMenungguVerifikasi = User::where('role', 'mitra')->where('status_mitra', 'menunggu_verifikasi')->count();
        $komplainBaru = Komplain::where('status', 'baru')->count();

        return view('dashboard', compact(
            'dari', 'sampai', 'totalPaket', 'menungguMitra', 'sedangDikerjakan', 'selesai',
            'grafikLabel', 'grafikData', 'pesananTerbaru', 'breakdownKategori',
            'pesananLamaMenunggu', 'mitraMenungguVerifikasi', 'komplainBaru'
        ));
    }
}