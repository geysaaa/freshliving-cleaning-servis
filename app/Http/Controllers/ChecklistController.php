<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChecklistController extends Controller
{
    public function update(Request $request, Pesanan $pesanan)
    {
        abort_unless($pesanan->mitra_id === Auth::id(), 403);

        $validated = $request->validate([
            'kunci' => ['required', 'string'],
            'checked' => ['required', 'boolean'],
        ]);

        $semuaKunci = $pesanan->paketLayanan->semuaKunciChecklist();
        abort_unless(in_array($validated['kunci'], $semuaKunci, true), 422, 'Item checklist tidak dikenal.');

        // SOP sebelum boleh diisi sejak menuju lokasi; sisanya saat sedang mengerjakan
        $kodeGrup = explode(':', $validated['kunci'])[0];
        $statusBoleh = $kodeGrup === 'sebelum'
            ? ['menuju_lokasi', 'sedang_mengerjakan']
            : ['sedang_mengerjakan'];
        abort_unless(in_array($pesanan->status, $statusBoleh, true), 409, 'Checklist ini belum bisa diisi pada status pesanan saat ini.');

        $selesai = collect($pesanan->checklist_selesai ?? []);

        $selesai = $request->boolean('checked')
            ? $selesai->push($validated['kunci'])->unique()
            : $selesai->reject(fn ($k) => $k === $validated['kunci']);

        $pesanan->update(['checklist_selesai' => $selesai->values()->all()]);

        return response()->json([
            'selesai' => count(array_intersect($pesanan->checklist_selesai, $semuaKunci)),
            'total' => count($semuaKunci),
        ]);
    }
}
