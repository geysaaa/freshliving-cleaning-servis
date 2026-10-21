<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{
    public function create(Pesanan $pesanan)
    {
        abort_unless($pesanan->pelanggan_id === Auth::id(), 403);
        return view('pembayaran.create', compact('pesanan'));
    }

    public function store(Request $request, Pesanan $pesanan)
    {
        abort_unless($pesanan->pelanggan_id === Auth::id(), 403);

        $validated = $request->validate([
            'metode_pembayaran' => 'required|in:transfer,cod',
            'bukti_transfer' => 'required_if:metode_pembayaran,transfer|nullable|image|max:2048',
        ]);

        if ($validated['metode_pembayaran'] === 'transfer') {
            $path = $request->file('bukti_transfer')->store('bukti-transfer', 'public');
            $pesanan->update([
                'metode_pembayaran' => 'transfer',
                'bukti_transfer' => $path,
                'status_pembayaran' => 'menunggu_verifikasi',
            ]);
            $pesan = 'Bukti transfer berhasil diunggah, menunggu verifikasi Admin.';
        } else {
            $pesanan->update([
                'metode_pembayaran' => 'cod',
                'status_pembayaran' => 'belum_bayar',
            ]);
            $pesan = 'Metode COD dipilih. Siapkan uang tunai saat mitra datang.';
        }

        return redirect()->route('pesanan.detail', $pesanan)->with('success', $pesan);
    }

    public function verify(Pesanan $pesanan)
    {
        $pesanan->update(['status_pembayaran' => 'lunas']);
        return back()->with('success', 'Pembayaran pesanan #' . $pesanan->id . ' berhasil diverifikasi.');
    }

    public function konfirmasiCod(Pesanan $pesanan)
    {
        abort_unless($pesanan->mitra_id === Auth::id(), 403);
        $pesanan->update(['status_pembayaran' => 'lunas']);
        return back()->with('success', 'Pembayaran COD dikonfirmasi diterima.');
    }

    public function nota(Pesanan $pesanan)
    {
        $isPemilik = $pesanan->pelanggan_id === Auth::id() || Auth::user()->role === 'admin';
        abort_unless($isPemilik, 403);
        return view('pembayaran.nota', compact('pesanan'));
    }
}