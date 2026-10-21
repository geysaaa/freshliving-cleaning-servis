@extends('layouts.dashboard')

@section('title', 'Pantau Transaksi')

@section('content')
    <div class="d-flex align-items-center gap-2 mb-1">
        <a href="javascript:history.back()" class="text-decoration-none text-dark"><i class="bi bi-arrow-left fs-4"></i></a>
        <h3 class="mb-0">Pantau Transaksi & Pesanan</h3>
    </div>
    <p class="text-muted mb-4">{{ $jumlahPerStatus['semua'] }} pesanan sedang berjalan</p>

    @php
        $tabs = [
            'semua' => ['label' => 'Semua', 'icon' => 'bi-grid'],
            'menunggu_mitra' => ['label' => 'Menunggu Mitra', 'icon' => 'bi-hourglass-split'],
            'dikonfirmasi' => ['label' => 'Dikonfirmasi', 'icon' => 'bi-check2-circle'],
            'menuju_lokasi' => ['label' => 'Menuju Lokasi', 'icon' => 'bi-signpost-2'],
            'sedang_mengerjakan' => ['label' => 'Sedang Dikerjakan', 'icon' => 'bi-gear-wide-connected'],
            'selesai' => ['label' => 'Selesai', 'icon' => 'bi-check-circle'],
        ];
        $badgeColor = [
            'menunggu_mitra' => 'secondary', 'dikonfirmasi' => 'warning', 'menuju_lokasi' => 'info',
            'sedang_mengerjakan' => 'primary', 'selesai' => 'success', 'dibatalkan' => 'danger',
        ];
    @endphp

    <div class="d-flex gap-2 mb-3 flex-wrap">
        @foreach ($tabs as $key => $t)
            <a href="{{ route('transaksi.index', ['status' => $key, 'cari' => request('cari')]) }}"
               class="btn btn-sm {{ ($status ?? 'semua') === $key ? 'btn-primary' : 'btn-light border' }} rounded-pill px-3">
                <i class="bi {{ $t['icon'] }} me-1"></i>{{ $t['label'] }}
                <span class="badge {{ ($status ?? 'semua') === $key ? 'bg-white text-primary' : 'bg-secondary-subtle text-secondary' }} ms-1">{{ $jumlahPerStatus[$key] }}</span>
            </a>
        @endforeach
    </div>

    <form method="GET" class="mb-3">
        <input type="hidden" name="status" value="{{ $status }}">
        <div class="input-group" style="max-width:400px;">
            <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
            <input type="text" name="cari" class="form-control border-start-0" placeholder="Cari nama pelanggan atau mitra..." value="{{ request('cari') }}">
            <button class="btn btn-outline-secondary">Cari</button>
        </div>
    </form>

    <div class="bg-white rounded-4 shadow-sm overflow-hidden">
        <table class="table table-hover mb-0 align-middle">
            <thead style="background:#f8f9fb;">
                <tr>
                    <th class="ps-4 py-3 text-muted small text-uppercase" style="letter-spacing:0.5px;">Pelanggan</th>
                    <th class="py-3 text-muted small text-uppercase" style="letter-spacing:0.5px;">Mitra</th>
                    <th class="py-3 text-muted small text-uppercase" style="letter-spacing:0.5px;">Paket</th>
                    <th class="py-3 text-muted small text-uppercase" style="letter-spacing:0.5px;">Jadwal</th>
                    <th class="py-3 text-muted small text-uppercase" style="letter-spacing:0.5px;">Total</th>
                    <th class="py-3 text-muted small text-uppercase" style="letter-spacing:0.5px;">Status</th>
<th class="pe-4 py-3 text-muted small text-uppercase" style="letter-spacing:0.5px;">Pembayaran</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pesanans as $pesanan)
                    <tr>
                        <td class="ps-4 fw-medium">{{ $pesanan->pelanggan->name ?? '-' }}</td>
                        <td class="text-muted">{{ $pesanan->mitra->name ?? 'Belum ditugaskan' }}</td>
                        <td>{{ $pesanan->paketLayanan->nama_paket }}</td>
                        <td class="text-muted">{{ $pesanan->jadwal->format('d M Y, H:i') }}</td>
                        <td class="fw-semibold">Rp{{ number_format($pesanan->total_tagihan, 0, ',', '.') }}</td>
                       <td>
    <span class="badge rounded-pill bg-{{ $badgeColor[$pesanan->status] ?? 'secondary' }}-subtle text-{{ $badgeColor[$pesanan->status] ?? 'secondary' }} px-3 py-2">
        {{ str_replace('_', ' ', $pesanan->status) }}
    </span>
</td>
<td class="pe-4">
    @if ($pesanan->status_pembayaran === 'lunas')
        <span class="badge bg-success-subtle text-success px-2 py-2">Lunas</span>
    @elseif ($pesanan->status_pembayaran === 'menunggu_verifikasi')
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-warning-subtle text-warning px-2 py-2">Menunggu</span>
            <form action="{{ route('pembayaran.verify', $pesanan) }}" method="POST">
                @csrf
                <button class="btn btn-sm btn-success py-0 px-2"><i class="bi bi-check-lg"></i></button>
            </form>
        </div>
    @else
    <div class="d-flex align-items-center gap-2">
        <span class="badge bg-secondary-subtle text-secondary px-2 py-2">Belum Bayar</span>
        @if ($pesanan->metode_pembayaran === 'cod')
            <form action="{{ route('pembayaran.verify', $pesanan) }}" method="POST">
                @csrf
                <button class="btn btn-sm btn-success py-0 px-2" title="Tandai lunas manual"><i class="bi bi-check-lg"></i></button>
            </form>
        @endif
    </div>
@endif
</td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-5">
                        <i class="bi bi-inbox fs-1 d-block mb-2 opacity-25"></i>
                        Tidak ada transaksi untuk filter ini.
                    </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">{{ $pesanans->links('pagination::bootstrap-5') }}</div>
@endsection