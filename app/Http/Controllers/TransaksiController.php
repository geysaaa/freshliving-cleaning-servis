<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $cari = $request->query('cari');

        $query = Pesanan::with(['pelanggan', 'mitra', 'paketLayanan'])->latest();

        if ($status && $status !== 'semua') {
            $query->where('status', $status);
        }

        if ($cari) {
            $query->where(function ($q) use ($cari) {
                $q->whereHas('pelanggan', fn ($qq) => $qq->where('name', 'like', "%{$cari}%"))
                  ->orWhereHas('mitra', fn ($qq) => $qq->where('name', 'like', "%{$cari}%"));
            });
        }

        $pesanans = $query->paginate(10)->withQueryString();

        $jumlahPerStatus = [
            'semua' => Pesanan::count(),
            'menunggu_mitra' => Pesanan::where('status', 'menunggu_mitra')->count(),
            'dikonfirmasi' => Pesanan::where('status', 'dikonfirmasi')->count(),
            'menuju_lokasi' => Pesanan::where('status', 'menuju_lokasi')->count(),
            'sedang_mengerjakan' => Pesanan::where('status', 'sedang_mengerjakan')->count(),
            'selesai' => Pesanan::where('status', 'selesai')->count(),
        ];

        return view('transaksi.index', compact('pesanans', 'jumlahPerStatus', 'status'));
    }
}