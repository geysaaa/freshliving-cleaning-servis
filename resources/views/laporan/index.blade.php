@extends('layouts.dashboard')

@section('title', 'Laporan Pendapatan')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2">
            <a href="javascript:history.back()" class="text-decoration-none text-dark"><i class="bi bi-arrow-left fs-4"></i></a>
            <h3 class="mb-0">Laporan Pendapatan</h3>
        </div>
        <form method="GET" class="d-flex gap-2">
            <input type="date" name="dari" class="form-control" value="{{ $dari->format('Y-m-d') }}">
            <input type="date" name="sampai" class="form-control" value="{{ $sampai->format('Y-m-d') }}">
            <button class="btn btn-primary"><i class="bi bi-funnel"></i> Filter</button>
        </form>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="bg-white rounded-4 shadow-sm p-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width:48px;height:48px; background:rgba(13,110,253,0.1);">
                        <i class="bi bi-graph-up-arrow text-primary"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block">Total Nilai Transaksi</small>
                        <h5 class="mb-0 fw-bold">Rp{{ number_format($totalTransaksi, 0, ',', '.') }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="bg-white rounded-4 shadow-sm p-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width:48px;height:48px; background:rgba(25,135,84,0.12);">
                        <i class="bi bi-cash-stack text-success"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block">Pendapatan Platform</small>
                        <h5 class="mb-0 fw-bold">Rp{{ number_format($totalKomisiPlatform, 0, ',', '.') }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="bg-white rounded-4 shadow-sm p-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width:48px;height:48px; background:rgba(13,202,240,0.15);">
                        <i class="bi bi-clipboard-check text-info"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block">Pesanan Selesai</small>
                        <h5 class="mb-0 fw-bold">{{ $totalPesanan }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="bg-white rounded-4 shadow-sm p-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width:48px;height:48px; background:rgba(255,193,7,0.15);">
                        <i class="bi bi-graph-up text-warning"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block">Rata-rata/Pesanan</small>
                        <h5 class="mb-0 fw-bold">Rp{{ number_format($rataRata, 0, ',', '.') }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-lg-8">
            <div class="bg-white rounded-4 shadow-sm p-4 h-100">
                <h6 class="mb-3 fw-bold">Pendapatan Platform - 6 Bulan Terakhir</h6>
                <canvas id="grafikPendapatan" height="90"></canvas>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="bg-white rounded-4 shadow-sm p-4 h-100">
                <h6 class="mb-3 fw-bold">Ringkasan per Bulan</h6>
                <table class="table table-sm mb-0">
                    <thead>
                        <tr class="text-muted small"><th>Bulan</th><th class="text-end">Komisi</th></tr>
                    </thead>
                    <tbody>
                        @foreach ($bulanData as $b)
                            <tr>
                                <td>{{ $b['label'] }}</td>
                                <td class="text-end fw-medium">Rp{{ number_format($b['total'], 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-4 shadow-sm overflow-hidden">
        <table class="table table-hover mb-0 align-middle">
            <thead style="background:#f8f9fb;">
                <tr>
                    <th class="ps-4 py-3 text-muted small text-uppercase" style="letter-spacing:0.5px;">Tanggal Selesai</th>
                    <th class="py-3 text-muted small text-uppercase" style="letter-spacing:0.5px;">Pelanggan</th>
                    <th class="py-3 text-muted small text-uppercase" style="letter-spacing:0.5px;">Paket</th>
                    <th class="py-3 text-muted small text-uppercase" style="letter-spacing:0.5px;">Total Transaksi</th>
                    <th class="py-3 text-muted small text-uppercase" style="letter-spacing:0.5px;">Komisi Platform</th>
                    <th class="pe-4 py-3 text-muted small text-uppercase" style="letter-spacing:0.5px;">Pendapatan Mitra</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pesananSelesai as $pesanan)
                    <tr>
                        <td class="ps-4 text-muted">{{ $pesanan->updated_at->format('d M Y, H:i') }}</td>
                        <td class="fw-medium">{{ $pesanan->pelanggan->name ?? '-' }}</td>
                        <td>{{ $pesanan->paketLayanan->nama_paket }}</td>
                        <td>Rp{{ number_format($pesanan->total_tagihan, 0, ',', '.') }}</td>
                        <td class="text-success fw-semibold">Rp{{ number_format($pesanan->komisi_platform, 0, ',', '.') }}</td>
                        <td class="pe-4">Rp{{ number_format($pesanan->pendapatan_mitra, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-5">
                        <i class="bi bi-graph-down fs-1 d-block mb-2 opacity-25"></i>
                        Belum ada transaksi selesai di rentang ini.
                    </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
    <script>
        new Chart(document.getElementById('grafikPendapatan'), {
            type: 'bar',
            data: {
                labels: @json($grafikLabel),
                datasets: [{
                    label: 'Komisi Platform (Rp)',
                    data: @json($grafikData),
                    backgroundColor: '#1f4e79',
                    borderRadius: 8,
                    maxBarThickness: 40,
                    categoryPercentage: 0.5,
                    barPercentage: 0.7,
                }]
            },
            options: {
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, ticks: { callback: v => 'Rp' + v.toLocaleString('id-ID') } } }
            }
        });
    </script>
@endsection