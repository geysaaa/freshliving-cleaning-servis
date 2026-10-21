<?php

namespace App\Http\Controllers;

use App\Models\PaketLayanan;
use Illuminate\Http\Request;

class PaketLayananController extends Controller
{
    public function index(Request $request)
    {
        $query = PaketLayanan::latest();

        if ($cari = $request->query('cari')) {
            $query->where('nama_paket', 'like', "%{$cari}%");
        }

        $paketLayanans = $query->paginate(10)->withQueryString();

        return view('paket.index', compact('paketLayanans'));
    }

    public function create()
    {
        return view('paket.create');
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'nama_paket' => 'required|string|max:255',
        'deskripsi' => 'nullable|string',
        'detail_layanan' => 'nullable|string',
        'harga' => 'required|integer|min:0',
        'estimasi_durasi_menit' => 'required|integer|min:1',
        'kategori' => 'required|in:rumah,kantor,spesial',
    ]);

    PaketLayanan::create($validated);

    return redirect()->route('paket.index')->with('success', 'Paket layanan berhasil ditambahkan.');
}

    public function edit(PaketLayanan $paket)
    {
        return view('paket.edit', compact('paket'));
    }

   public function update(Request $request, PaketLayanan $paket)
{
    $validated = $request->validate([
        'nama_paket' => 'required|string|max:255',
        'deskripsi' => 'nullable|string',
        'detail_layanan' => 'nullable|string',
        'harga' => 'required|integer|min:0',
        'estimasi_durasi_menit' => 'required|integer|min:1',
        'kategori' => 'required|in:rumah,kantor,spesial',
        'aktif' => 'boolean',
    ]);

    $paket->update($validated);

    return redirect()->route('paket.index')->with('success', 'Paket layanan berhasil diperbarui.');
}

    public function destroy(PaketLayanan $paket)
    {
        $paket->delete();
        return redirect()->route('paket.index')->with('success', 'Paket layanan berhasil dihapus.');
    }
    public function show(PaketLayanan $paket)
{
    return view('pesanan.paket-detail', compact('paket'));
}
}