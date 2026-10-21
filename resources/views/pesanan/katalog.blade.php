@extends('layouts.pelanggan')

@section('title', 'Katalog Layanan')

@section('content')
    <style>
        .katalog-card { transition: transform 0.2s ease, box-shadow 0.2s ease; }
        .katalog-card:hover { transform: translateY(-4px); box-shadow: 0 12px 28px rgba(0,0,0,0.08) !important; }
    </style>

    <h3 class="mb-1">Pilih Layanan Cleaning</h3>
    <p class="text-muted mb-3">Pilih paket yang sesuai kebutuhanmu</p>

    @php
        $kategoriWarna = ['rumah' => 'primary', 'kantor' => 'success', 'spesial' => 'warning'];
        $kategoriLabel = ['rumah' => 'Rumah', 'kantor' => 'Kantor', 'spesial' => 'Spesial'];
    @endphp

    <div class="d-flex gap-2 mb-4">
        <a href="{{ route('pesanan.katalog') }}" class="btn btn-sm {{ !request('kategori') ? 'btn-primary' : 'btn-light border' }} rounded-pill px-3">Semua</a>
        <a href="{{ route('pesanan.katalog', ['kategori' => 'rumah']) }}" class="btn btn-sm {{ request('kategori') === 'rumah' ? 'btn-primary' : 'btn-light border' }} rounded-pill px-3">Rumah</a>
        <a href="{{ route('pesanan.katalog', ['kategori' => 'kantor']) }}" class="btn btn-sm {{ request('kategori') === 'kantor' ? 'btn-primary' : 'btn-light border' }} rounded-pill px-3">Kantor</a>
        <a href="{{ route('pesanan.katalog', ['kategori' => 'spesial']) }}" class="btn btn-sm {{ request('kategori') === 'spesial' ? 'btn-primary' : 'btn-light border' }} rounded-pill px-3">Spesial</a>
    </div>

    <div class="row g-3">
        @forelse ($paketLayanans as $paket)
            <div class="col-md-4">
                <div class="bg-white rounded-4 shadow-sm p-4 h-100 d-flex flex-column katalog-card">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="rounded-3 d-flex align-items-center justify-content-center" style="width:56px;height:56px; background:rgba(13,110,253,0.1);">
                            <i class="bi bi-house-heart fs-3 text-primary"></i>
                        </div>
                        <span class="badge rounded-pill bg-{{ $kategoriWarna[$paket->kategori] ?? 'primary' }}-subtle text-{{ $kategoriWarna[$paket->kategori] ?? 'primary' }} px-3 py-2">
                            {{ $kategoriLabel[$paket->kategori] ?? 'Rumah' }}
                        </span>
                    </div>
                    <h5 class="fw-bold">{{ $paket->nama_paket }}</h5>
                    <p class="text-muted small flex-grow-1">{{ $paket->deskripsi }}</p>
                    <div class="fw-bold fs-4 text-primary mb-1">Rp{{ number_format($paket->harga, 0, ',', '.') }}</div>
                    <small class="text-muted mb-3"><i class="bi bi-clock me-1"></i>{{ $paket->estimasi_durasi_menit }} menit</small>
                    <a href="{{ route('pesanan.paketDetail', $paket) }}" class="btn btn-outline-primary w-100 mb-2">Lihat Detail</a>
<a href="{{ route('pesanan.create', ['paket_layanan_id' => $paket->id]) }}" class="btn btn-primary w-100">Pilih Paket</a>
                </div>
            </div>
        @empty
            <p class="text-muted">Belum ada paket layanan tersedia.</p>
        @endforelse
    </div>
@endsection