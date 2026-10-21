<?php

namespace App\Http\Controllers;

use App\Models\PaketLayanan;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesananController extends Controller
{
    public function create()
    {
        $paketLayanans = PaketLayanan::where('aktif', true)->get();
        return view('pesanan.create', compact('paketLayanans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'paket_layanan_id' => 'required|exists:paket_layanans,id',
            'alamat' => 'required|string|max:500',
            'catatan_tambahan' => 'nullable|string',
            'jadwal' => 'required|date|after:now',
        ]);

        $paket = PaketLayanan::findOrFail($validated['paket_layanan_id']);

        $persenKomisi = 15; // 15% untuk platform, bisa diubah di sini
        $komisi = intval($paket->harga * $persenKomisi / 100);
        $pendapatanMitra = $paket->harga - $komisi;

        $pesanan = Pesanan::create([
            'pelanggan_id' => Auth::id(),
            'paket_layanan_id' => $paket->id,
            'alamat' => $validated['alamat'],
            'catatan_tambahan' => $validated['catatan_tambahan'] ?? null,
            'jadwal' => $validated['jadwal'],
            'status' => 'menunggu_mitra',
            'total_tagihan' => $paket->harga,
            'komisi_platform' => $komisi,
            'pendapatan_mitra' => $pendapatanMitra,
        ]);

        $mitra = app(\App\Services\MitraMatchingService::class)->carikanMitra($pesanan);
        if ($mitra) {
            $pesanan->update(['mitra_id' => $mitra->id]);
        }

        return redirect()->route('pesanan.riwayat')->with('success', 'Pesanan berhasil dibuat, menunggu mitra tersedia.');
    }

    public function riwayat()
    {
        $pesanans = Pesanan::where('pelanggan_id', Auth::id())
            ->with(['paketLayanan', 'mitra'])
            ->latest()
            ->get();

        return view('pesanan.riwayat', compact('pesanans'));
    }

    public function detail(Pesanan $pesanan)
    {
        abort_unless($pesanan->pelanggan_id === Auth::id(), 403);
        return view('pesanan.detail', compact('pesanan'));
    }

    public function batalkan(Pesanan $pesanan)
    {
        abort_unless($pesanan->pelanggan_id === Auth::id(), 403);

        $bisaDibatalkan = in_array($pesanan->status, ['menunggu_mitra', 'dikonfirmasi'])
            && $pesanan->status_pembayaran === 'belum_bayar';

        if (!$bisaDibatalkan) {
            return back()->with('error', 'Pesanan ini sudah tidak bisa dibatalkan.');
        }

        $pesanan->update(['status' => 'dibatalkan']);

        return back()->with('success', 'Pesanan #' . $pesanan->id . ' berhasil dibatalkan.');
    }

    public function updateStatus(Request $request, Pesanan $pesanan)
    {
        $validated = $request->validate([
            'status' => 'required|in:menuju_lokasi,sedang_mengerjakan,selesai',
        ]);

        abort_unless($pesanan->mitra_id === Auth::id(), 403);
        abort_unless(
            in_array($pesanan->status, ['dikonfirmasi', 'menuju_lokasi', 'sedang_mengerjakan']),
            409,
            'Pesanan ini sudah tidak aktif (mungkin dibatalkan pelanggan).'
        );

        $pesanan->update(['status' => $validated['status']]);

        return back()->with('success', 'Status pesanan diperbarui menjadi: ' . $validated['status']);
    }

    public function accept(Pesanan $pesanan)
    {
        abort_unless($pesanan->mitra_id === Auth::id(), 403);
        abort_unless($pesanan->status === 'menunggu_mitra', 409, 'Pesanan ini sudah tidak tersedia (mungkin dibatalkan pelanggan).');

        $pesanan->update(['status' => 'dikonfirmasi']);
        return back()->with('success', 'Pesanan diterima.');
    }

    public function reject(Pesanan $pesanan)
    {
        abort_unless($pesanan->mitra_id === Auth::id(), 403);
        abort_unless($pesanan->status === 'menunggu_mitra', 409, 'Pesanan ini sudah tidak tersedia (mungkin dibatalkan pelanggan).');

        $pesanan->update(['mitra_id' => null]);
        $mitraBaru = app(\App\Services\MitraMatchingService::class)->carikanMitra($pesanan);
        if ($mitraBaru) {
            $pesanan->update(['mitra_id' => $mitraBaru->id]);
        }

        return back()->with('success', 'Pesanan ditolak, dicarikan mitra lain.');
    }

    public function pesananMasuk()
    {
        $pesanans = Pesanan::where('mitra_id', Auth::id())
            ->where('status', 'menunggu_mitra')
            ->with('paketLayanan')
            ->get();

        return view('mitra.pesanan_masuk', compact('pesanans'));
    }

    public function tugasSaya()
    {
        $pesanans = Pesanan::where('mitra_id', Auth::id())
            ->whereIn('status', ['dikonfirmasi', 'menuju_lokasi', 'sedang_mengerjakan'])
            ->with('paketLayanan')
            ->get();

        return view('mitra.tugas_saya', compact('pesanans'));
    }

    public function riwayatMitra()
    {
        $mitraId = Auth::id();

        $pesanans = Pesanan::where('mitra_id', $mitraId)
            ->where('status', 'selesai')
            ->with(['pelanggan', 'paketLayanan', 'rating'])
            ->latest('updated_at')
            ->get();

        $totalPesananSelesai = $pesanans->count();
        $totalPendapatanBulanIni = $pesanans->filter(fn ($p) => $p->updated_at->isSameMonth(now()))->sum('pendapatan_mitra');

        return view('mitra.riwayat', compact('pesanans', 'totalPesananSelesai', 'totalPendapatanBulanIni'));
    }

    public function katalog(Request $request)
    {
        $query = PaketLayanan::where('aktif', true);

        if ($kategori = $request->query('kategori')) {
            $query->where('kategori', $kategori);
        }

        $paketLayanans = $query->get();

        return view('pesanan.katalog', compact('paketLayanans'));
    }
}