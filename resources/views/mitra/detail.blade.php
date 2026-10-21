@extends('layouts.dashboard')

@section('title', 'Detail Registrasi Mitra')

@section('content')
    <div class="d-flex align-items-center gap-2 mb-4">
        <a href="{{ route('mitra.index') }}" class="text-decoration-none text-dark"><i class="bi bi-arrow-left fs-4"></i></a>
        <h3 class="mb-0">Detail Registrasi Mitra</h3>
    </div>

    <div class="bg-white rounded-3 shadow-sm p-4 mb-3" style="max-width: 650px;">
        <div class="d-flex gap-3 mb-4">
            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center fw-semibold fs-3" style="width:80px;height:80px;flex-shrink:0;">
                {{ strtoupper(substr($mitra->name, 0, 1)) }}
            </div>
            <div>
                <h5 class="mb-1">{{ $mitra->name }}</h5>
                <div class="text-muted mb-2"><i class="bi bi-envelope me-1"></i>{{ $mitra->email }}</div>
                @if ($mitra->status_mitra === 'aktif')
                    <span class="badge rounded-pill bg-success-subtle text-success px-3 py-2">Aktif</span>
                @elseif ($mitra->status_mitra === 'ditolak')
                    <span class="badge rounded-pill bg-danger-subtle text-danger px-3 py-2">Ditolak</span>
                @else
    <span class="badge rounded-pill bg-warning-subtle text-warning px-3 py-2">Menunggu Verifikasi</span>
@endif
<div class="mt-2">
    @if ($mitra->jumlah_rating > 0)
        <i class="bi bi-star-fill text-warning"></i> {{ number_format($mitra->rata_rating, 1) }} dari 5 <small class="text-muted">({{ $mitra->jumlah_rating }} ulasan)</small>
    @else
        <small class="text-muted">Belum ada rating</small>
    @endif
</div>
</div>
</div>

        <div class="row mb-4">
            <div class="col-6">
                <small class="text-muted d-block">Area Layanan</small>
                <div class="fw-medium">{{ $mitra->area_layanan ?? '-' }}</div>
            </div>
            <div class="col-6">
                <small class="text-muted d-block">Keahlian</small>
                <div class="fw-medium">{{ $mitra->keahlian ?? '-' }}</div>
            </div>
            <div class="col-6 mt-3">
                <small class="text-muted d-block">Tanggal Mendaftar</small>
                <div class="fw-medium">{{ $mitra->created_at->format('d M Y') }}</div>
            </div>
        </div>

        <h6 class="mb-2">Foto KTP</h6>
        @if ($mitra->foto_ktp)
            <a href="{{ asset('storage/' . $mitra->foto_ktp) }}" target="_blank">
                <img src="{{ asset('storage/' . $mitra->foto_ktp) }}" class="rounded-3 border" style="max-height:220px; max-width:100%; object-fit:cover;">
            </a>
        @else
            <div class="bg-light rounded-3 p-4 text-center text-muted">
                <i class="bi bi-file-earmark-x fs-2 d-block mb-2"></i>
                Belum ada foto KTP diunggah
            </div>
        @endif
    </div>

    @if ($mitra->status_mitra !== 'aktif' || $mitra->status_mitra !== 'ditolak')
        <div class="d-flex gap-2" style="max-width: 650px;">
            @if ($mitra->status_mitra !== 'ditolak')
                <form action="{{ route('mitra.reject', $mitra) }}" method="POST" class="flex-fill">
                    @csrf
                    <button class="btn btn-outline-danger w-100"><i class="bi bi-x-lg me-1"></i>Tolak Pendaftaran</button>
                </form>
            @endif
            @if ($mitra->status_mitra !== 'aktif')
                <form action="{{ route('mitra.verify', $mitra) }}" method="POST" class="flex-fill">
                    @csrf
                    <button class="btn btn-success w-100"><i class="bi bi-check-lg me-1"></i>Setujui & Aktifkan Mitra</button>
                </form>
            @endif
        </div>
    @endif
@endsection