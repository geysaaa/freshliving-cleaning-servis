<?php

namespace App\Http\Controllers;

use App\Models\Komplain;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KomplainController extends Controller
{
    public function create(Request $request, Pesanan $pesanan)
    {
        abort_unless($pesanan->pelanggan_id === Auth::id(), 403);

        $jenis = (string) $request->query('jenis', '');
        $jenisAwal = isset(Komplain::JENIS[$jenis]) ? $jenis : 'kualitas';

        return view('komplain.create', compact('pesanan', 'jenisAwal'));
    }

    public function store(Request $request, Pesanan $pesanan)
    {
        abort_unless($pesanan->pelanggan_id === Auth::id(), 403);

        $validated = $request->validate([
            'jenis_masalah' => 'required|in:' . implode(',', array_keys(Komplain::JENIS)),
            'deskripsi' => 'required|string',
            'foto_bukti' => 'nullable|image|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('foto_bukti')) {
            $path = $request->file('foto_bukti')->store('komplain', 'public');
        }

        Komplain::create([
            'pesanan_id' => $pesanan->id,
            'pelanggan_id' => Auth::id(),
            'jenis_masalah' => $validated['jenis_masalah'],
            'deskripsi' => $validated['deskripsi'],
            'foto_bukti' => $path,
            'status' => 'baru',
        ]);

        return redirect()->route('pesanan.riwayat')->with('success', 'Komplain berhasil dikirim.');
    }

    public function index(Request $request)
    {
        $query = Komplain::with(['pesanan', 'pelanggan'])->latest();

        if ($cari = $request->query('cari')) {
            $query->whereHas('pelanggan', fn ($q) => $q->where('name', 'like', "%{$cari}%"));
        }

        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }

        if ($jenis = $request->query('jenis')) {
            $query->where('jenis_masalah', $jenis);
        }

        $komplains = $query->paginate(10)->withQueryString();

        return view('komplain.index', compact('komplains'));
    }

    public function update(Request $request, Komplain $komplain)
    {
        $validated = $request->validate([
            'status' => 'required|in:baru,diproses,selesai',
            'tanggapan_admin' => 'nullable|string',
        ]);

        $komplain->update($validated);

        return back()->with('success', 'Komplain diperbarui.');
    }
}
