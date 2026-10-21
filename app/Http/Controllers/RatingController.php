<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function create(Pesanan $pesanan)
    {
        return view('rating.create', compact('pesanan'));
    }

    public function store(Request $request, Pesanan $pesanan)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'ulasan' => 'nullable|string',
        ]);

        Rating::updateOrCreate(['pesanan_id' => $pesanan->id], $validated);

        return redirect()->route('pesanan.riwayat')->with('success', 'Terima kasih atas penilaiannya!');
    }
}