@extends('layouts.dashboard')

@section('title', 'Tugas Saya')

@section('content')
    <h3 class="mb-1">Tugas Saya</h3>
    <p class="text-muted mb-4">Pekerjaan yang sedang kamu jalani</p>

    @php
        $badgeColor = ['dikonfirmasi' => 'warning', 'menuju_lokasi' => 'info', 'sedang_mengerjakan' => 'primary'];
        $labelStatus = ['dikonfirmasi' => 'Dikonfirmasi', 'menuju_lokasi' => 'Menuju Lokasi', 'sedang_mengerjakan' => 'Sedang Dikerjakan'];
    @endphp

    @forelse ($pesanans as $pesanan)
        <div class="bg-white rounded-4 shadow-sm p-4 mb-3">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                <div>
                    <span class="badge rounded-pill bg-{{ $badgeColor[$pesanan->status] ?? 'secondary' }}-subtle text-{{ $badgeColor[$pesanan->status] ?? 'secondary' }} px-3 py-2 mb-2">
                        {{ $labelStatus[$pesanan->status] ?? $pesanan->status }}
                    </span>
                    <div class="fw-bold fs-5">{{ $pesanan->paketLayanan->nama_paket }}</div>
                    <small class="text-muted d-block mt-1"><i class="bi bi-geo-alt me-1"></i>{{ $pesanan->alamat }}</small>
                </div>
                <div>
                    @if ($pesanan->status === 'dikonfirmasi')
                        <form action="{{ route('pesanan.updateStatus', $pesanan) }}" method="POST">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="menuju_lokasi">
                            <button class="btn btn-primary"><i class="bi bi-arrow-right me-1"></i>Menuju Lokasi</button>
                        </form>
                    @elseif ($pesanan->status === 'menuju_lokasi')
                        <form action="{{ route('pesanan.updateStatus', $pesanan) }}" method="POST">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="sedang_mengerjakan">
                            <button class="btn btn-primary"><i class="bi bi-tools me-1"></i>Mulai Kerjakan</button>
                        </form>
                    @elseif ($pesanan->status === 'sedang_mengerjakan')
    <div class="d-flex flex-column gap-2">
        <form action="{{ route('pesanan.updateStatus', $pesanan) }}" method="POST">
            @csrf @method('PATCH')
            <input type="hidden" name="status" value="selesai">
            <button class="btn btn-success w-100"><i class="bi bi-check-lg me-1"></i>Tandai Selesai</button>
        </form>
        @if ($pesanan->metode_pembayaran === 'cod' && $pesanan->status_pembayaran !== 'lunas')
            <form action="{{ route('pembayaran.konfirmasiCod', $pesanan) }}" method="POST">
                @csrf
                <button class="btn btn-outline-success btn-sm w-100"><i class="bi bi-cash-coin me-1"></i>Konfirmasi Uang COD Diterima</button>
            </form>
        @endif
    </div>
@endif
                </div>
            </div>
        </div>
    @empty
        <div class="bg-white rounded-4 shadow-sm text-center text-muted py-5">
            <i class="bi bi-list-check fs-1 d-block mb-2 opacity-25"></i>
            Belum ada tugas aktif.
        </div>
    @endforelse
@endsection