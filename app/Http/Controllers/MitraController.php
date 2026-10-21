<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\User;
use Illuminate\Http\Request;

class MitraController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'mitra')->latest();

        if ($cari = $request->query('cari')) {
            $query->where(function ($q) use ($cari) {
                $q->where('name', 'like', "%{$cari}%")->orWhere('email', 'like', "%{$cari}%");
            });
        }

        if ($status = $request->query('status')) {
            $query->where('status_mitra', $status);
        }

        $mitras = $query->paginate(10)->withQueryString();

        foreach ($mitras as $mitra) {
            $mitra->rata_rating = Rating::whereHas('pesanan', fn ($q) => $q->where('mitra_id', $mitra->id))->avg('rating');
            $mitra->jumlah_rating = Rating::whereHas('pesanan', fn ($q) => $q->where('mitra_id', $mitra->id))->count();
        }

        return view('mitra.index', compact('mitras'));
    }

    public function detail(User $mitra)
    {
        $mitra->rata_rating = Rating::whereHas('pesanan', fn ($q) => $q->where('mitra_id', $mitra->id))->avg('rating');
        $mitra->jumlah_rating = Rating::whereHas('pesanan', fn ($q) => $q->where('mitra_id', $mitra->id))->count();

        return view('mitra.detail', compact('mitra'));
    }

    public function verify(User $mitra)
    {
        $mitra->update(['status_mitra' => 'aktif']);
        return back()->with('success', 'Mitra ' . $mitra->name . ' berhasil diverifikasi.');
    }

    public function reject(User $mitra)
    {
        $mitra->update(['status_mitra' => 'ditolak']);
        return back()->with('success', 'Pendaftaran mitra ' . $mitra->name . ' ditolak.');
    }
}