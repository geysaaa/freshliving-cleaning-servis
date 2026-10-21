@extends('layouts.dashboard')

@section('title', 'Riwayat & Pendapatan')

@section('content')
    <h3 class="mb-1">Riwayat & Pendapatan</h3>
    <p class="text-muted mb-4">Ringkasan pekerjaan dan penghasilanmu</p>

    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="bg-white rounded-4 shadow-sm p-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width:52px;height:52px; background:rgba(13,110,253,0.1);">
                        <i class="bi bi-clipboard-check fs-4 text-primary"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block">Total Pesanan Selesai</small>
                        <h4 class="mb-0 fw-bold">{{ $totalPesananSelesai }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="bg-white rounded-4 shadow-sm p-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width:52px;height:52px; background:rgba(25,135,84,0.12);">
                        <i class="bi bi-cash-stack fs-4 text-success"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block">Pendapatan Bulan Ini</small>
                        <h4 class="mb-0 fw-bold">Rp{{ number_format($totalPendapatanBulanIni, 0, ',', '.') }}</h4>
                    </div>
                </div>
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
                    <th class="py-3 text-muted small text-uppercase" style="letter-spacing:0.5px;">Rating</th>
                    <th class="py-3 text-muted small text-uppercase" style="letter-spacing:0.5px;">Pendapatan</th>
<th class="pe-4 py-3 text-muted small text-uppercase" style="letter-spacing:0.5px;">Pembayaran</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pesanans as $pesanan)
                    <tr>
                        <td class="ps-4 text-muted">{{ $pesanan->updated_at->format('d M Y, H:i') }}</td>
                        <td class="fw-medium">{{ $pesanan->pelanggan->name ?? '-' }}</td>
                        <td>{{ $pesanan->paketLayanan->nama_paket }}</td>
                        <td>
                            @if ($pesanan->rating)
                                <i class="bi bi-star-fill text-warning"></i> {{ $pesanan->rating->rating }}
                            @else
                                <span class="text-muted">Belum dinilai</span>
                            @endif
                        </td>
                        <td class="fw-semibold text-success">Rp{{ number_format($pesanan->pendapatan_mitra, 0, ',', '.') }}</td>
<td class="pe-4">
    @if ($pesanan->status_pembayaran === 'lunas')
        <span class="badge bg-success-subtle text-success px-2 py-2">Lunas</span>
    @elseif ($pesanan->metode_pembayaran === 'cod')
        <form action="{{ route('pembayaran.konfirmasiCod', $pesanan) }}" method="POST">
            @csrf
            <button class="btn btn-sm btn-outline-success">Konfirmasi COD</button>
        </form>
    @else
        <span class="badge bg-warning-subtle text-warning px-2 py-2">Menunggu Verifikasi</span>
    @endif
</td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-5">
                        <i class="bi bi-clock-history fs-1 d-block mb-2 opacity-25"></i>
                        Belum ada pesanan yang selesai.
                    </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection