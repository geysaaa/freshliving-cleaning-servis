@extends('layouts.pelanggan')

@section('title', 'Riwayat Pesanan')

@section('content')
    <h3 class="mb-4">Riwayat Pesanan Saya</h3>

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @php
        $badgeColor = [
            'menunggu_mitra' => 'secondary', 'dikonfirmasi' => 'warning', 'menuju_lokasi' => 'info',
            'sedang_mengerjakan' => 'primary', 'selesai' => 'success', 'dibatalkan' => 'danger',
        ];
    @endphp

    @forelse ($pesanans as $pesanan)
        @php
            $bisaBatal = in_array($pesanan->status, ['menunggu_mitra', 'dikonfirmasi'])
                && $pesanan->status_pembayaran === 'belum_bayar';
        @endphp

        <div class="bg-white rounded-4 shadow-sm p-4 mb-3 position-relative" style="{{ $pesanan->status === 'dibatalkan' ? 'opacity:.65;' : '' }}">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width:48px;height:48px; background:rgba(13,110,253,0.1);">
                        <i class="bi bi-house-heart text-primary"></i>
                    </div>
                    <div>
                        <a href="{{ route('pesanan.detail', $pesanan) }}" class="fw-semibold text-dark text-decoration-none stretched-link">{{ $pesanan->paketLayanan->nama_paket }}</a>
                        <div>
                            <small class="text-muted">
                                <i class="bi bi-calendar me-1"></i>{{ $pesanan->jadwal->format('d M Y, H:i') }} •
                                <i class="bi bi-person me-1"></i>{{ $pesanan->mitra->name ?? 'Belum ditugaskan' }}
                            </small>
                        </div>
                    </div>
                </div>

                <div class="text-end">
                    <div class="fw-semibold mb-1">Rp{{ number_format($pesanan->total_tagihan, 0, ',', '.') }}</div>
                    <span class="badge rounded-pill bg-{{ $badgeColor[$pesanan->status] ?? 'secondary' }}-subtle text-{{ $badgeColor[$pesanan->status] ?? 'secondary' }} px-3 py-2">
                        {{ str_replace('_', ' ', $pesanan->status) }}
                    </span>

                    @if ($bisaBatal)
                        <form action="{{ route('pesanan.batalkan', $pesanan) }}" method="POST" class="mt-2" style="position:relative; z-index:2;"
                              onsubmit="return confirm('Yakin ingin membatalkan pesanan {{ $pesanan->paketLayanan->nama_paket }}?')">
                            @csrf
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-x-circle me-1"></i>Batalkan Pesanan</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="text-center py-5">
            <i class="bi bi-clipboard-x text-muted" style="font-size: 4rem; opacity: 0.3;"></i>
            <p class="text-muted mt-3 mb-3">Kamu belum pernah memesan layanan cleaning</p>
            <a href="{{ route('pesanan.katalog') }}" class="btn btn-primary">Pesan Sekarang</a>
        </div>
    @endforelse
@endsection