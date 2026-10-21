<?php

namespace App\Http\Controllers;

use App\Models\JadwalMitra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalMitraController extends Controller
{
    private array $hariList = ['senin','selasa','rabu','kamis','jumat','sabtu','minggu'];

    public function index()
    {
        $jadwals = JadwalMitra::where('mitra_id', Auth::id())->get()->keyBy('hari');
        return view('mitra.jadwal', ['jadwals' => $jadwals, 'hariList' => $this->hariList]);
    }

    public function update(Request $request)
    {
        foreach ($this->hariList as $hari) {
            JadwalMitra::updateOrCreate(
                ['mitra_id' => Auth::id(), 'hari' => $hari],
                ['tersedia' => $request->has("tersedia_$hari")]
            );
        }

        return back()->with('success', 'Jadwal ketersediaan diperbarui.');
    }
}