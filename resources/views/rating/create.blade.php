@extends('layouts.pelanggan')

@section('title', 'Beri Rating')

@section('content')
    <h3 class="mb-4">Beri Rating untuk {{ $pesanan->mitra->name ?? 'Mitra' }}</h3>

    <div class="bg-white rounded-3 shadow-sm p-4" style="max-width: 450px;">
        <div class="text-center mb-4">
            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center fw-semibold fs-3 mb-2" style="width:64px;height:64px;">
                {{ strtoupper(substr($pesanan->mitra->name ?? 'M', 0, 1)) }}
            </div>
            <div class="fw-semibold">{{ $pesanan->mitra->name ?? 'Mitra' }}</div>
            <small class="text-muted">{{ $pesanan->paketLayanan->nama_paket }}</small>
        </div>

        <form action="{{ route('rating.store', $pesanan) }}" method="POST">
            @csrf
            <div class="mb-3 text-center">
                <label class="form-label fw-medium d-block">Beri Rating</label>
                <select name="rating" class="form-select" required style="max-width:200px; margin:0 auto;">
                    <option value="5">⭐⭐⭐⭐⭐ Sangat Puas</option>
                    <option value="4">⭐⭐⭐⭐ Puas</option>
                    <option value="3">⭐⭐⭐ Cukup</option>
                    <option value="2">⭐⭐ Kurang</option>
                    <option value="1">⭐ Buruk</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label fw-medium">Ulasan (opsional)</label>
                <textarea name="ulasan" class="form-control" rows="3" placeholder="Ceritakan pengalamanmu..."></textarea>
            </div>
            <button class="btn btn-primary w-100 py-2">Kirim Ulasan</button>
        </form>
    </div>
@endsection