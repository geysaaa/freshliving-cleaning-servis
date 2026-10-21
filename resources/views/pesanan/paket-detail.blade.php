@extends('layouts.pelanggan')

@section('title', $paket->nama_paket)

@section('content')
    <div class="mx-auto" style="max-width: 650px;">
        <div class="position-relative text-center mb-4">
            <a href="{{ route('pesanan.katalog') }}" class="position-absolute start-0 top-50 translate-middle-y text-decoration-none text-dark"><i class="bi bi-arrow-left fs-4"></i></a>
            <h3 class="mb-0">Detail Paket</h3>
        </div>

        @php
            $kategoriWarna = ['rumah' => 'primary', 'kantor' => 'success', 'spesial' => 'warning'];
            $kategoriLabel = ['rumah' => 'Rumah', 'kantor' => 'Kantor', 'spesial' => 'Spesial'];
        @endphp

        <div class="bg-white rounded-4 shadow-sm p-4">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="rounded-3 d-flex align-items-center justify-content-center" style="width:64px;height:64px; background:rgba(13,110,253,0.1);">
                    <i class="bi bi-house-heart fs-2 text-primary"></i>
                </div>
                <span class="badge rounded-pill bg-{{ $kategoriWarna[$paket->kategori] ?? 'primary' }}-subtle text-{{ $kategoriWarna[$paket->kategori] ?? 'primary' }} px-3 py-2">
                    {{ $kategoriLabel[$paket->kategori] ?? 'Rumah' }}
                </span>
            </div>

            <h3 class="fw-bold">{{ $paket->nama_paket }}</h3>
            <p class="text-muted">{{ $paket->deskripsi }}</p>

            <div class="d-flex align-items-center gap-4 my-3 py-3 border-top border-bottom">
                <div>
                    <small class="text-muted d-block">Harga</small>
                    <span class="fw-bold fs-4 text-primary">Rp{{ number_format($paket->harga, 0, ',', '.') }}</span>
                </div>
                <div>
                    <small class="text-muted d-block">Estimasi Durasi</small>
                    <span class="fw-medium"><i class="bi bi-clock me-1"></i>{{ $paket->estimasi_durasi_menit }} menit</span>
                </div>
            </div>

            @if ($paket->detail_layanan)
                <h6 class="fw-bold mb-3">Yang Termasuk dalam Paket Ini</h6>
                <ul class="list-unstyled mb-4">
                    @foreach (explode("\n", trim($paket->detail_layanan)) as $item)
                        @if (trim($item) !== '')
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>{{ trim($item) }}</li>
                        @endif
                    @endforeach
                </ul>
            @endif

            <a href="{{ route('pesanan.create', ['paket_layanan_id' => $paket->id]) }}" class="btn btn-primary w-100 py-2">Pilih Paket Ini</a>
        </div>
    </div>
@endsection