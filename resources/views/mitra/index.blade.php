@extends('layouts.dashboard')

@section('title', 'Data Mitra')

@section('content')
    <div class="d-flex align-items-center gap-2 mb-4">
        <a href="javascript:history.back()" class="text-decoration-none text-dark"><i class="bi bi-arrow-left fs-4"></i></a>
        <div>
            <h3 class="mb-1">Data Mitra</h3>
            <p class="text-muted mb-0">Total {{ $mitras->total() }} mitra terdaftar</p>
        </div>
    </div>

    <form method="GET" class="d-flex gap-2 mb-3 flex-wrap">
        <div class="input-group" style="max-width:350px;">
            <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
            <input type="text" name="cari" class="form-control border-start-0" placeholder="Cari nama atau email..." value="{{ request('cari') }}">
        </div>
        <select name="status" class="form-select" style="max-width:200px;" onchange="this.form.submit()">
            <option value="">Semua Status</option>
            <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
            <option value="menunggu_verifikasi" {{ request('status') === 'menunggu_verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
            <option value="ditolak" {{ request('status') === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
        </select>
        <button class="btn btn-outline-secondary">Cari</button>
    </form>

    <div class="bg-white rounded-4 shadow-sm overflow-hidden">
        <table class="table table-hover mb-0 align-middle">
            <thead style="background:#f8f9fb;">
                <tr>
                    <th class="ps-4 py-3 text-muted small text-uppercase" style="letter-spacing:0.5px;">Nama</th>
                    <th class="py-3 text-muted small text-uppercase" style="letter-spacing:0.5px;">Email</th>
                    <th class="py-3 text-muted small text-uppercase" style="letter-spacing:0.5px;">Area Layanan</th>
                    <th class="py-3 text-muted small text-uppercase" style="letter-spacing:0.5px;">Keahlian</th>
                    <th class="py-3 text-muted small text-uppercase" style="letter-spacing:0.5px;">Rating</th>
                    <th class="py-3 text-muted small text-uppercase" style="letter-spacing:0.5px;">Status</th>
                    <th class="text-end pe-4 py-3 text-muted small text-uppercase" style="letter-spacing:0.5px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($mitras as $mitra)
                    <tr>
                        <td class="ps-4">
                            <a href="{{ route('mitra.detail', $mitra) }}" class="d-flex align-items-center gap-2 text-decoration-none text-dark">
                                <span class="rounded-circle d-flex align-items-center justify-content-center fw-semibold" style="width:38px;height:38px; background:rgba(13,110,253,0.1); color:#0d6efd;">
                                    {{ strtoupper(substr($mitra->name, 0, 1)) }}
                                </span>
                                <span class="fw-medium">{{ $mitra->name }}</span>
                            </a>
                        </td>
                        <td class="text-muted">{{ $mitra->email }}</td>
                        <td>{{ $mitra->area_layanan ?? '-' }}</td>
                        <td>{{ $mitra->keahlian ?? '-' }}</td>
                        <td>
                            @if ($mitra->jumlah_rating > 0)
                                <span class="fw-medium"><i class="bi bi-star-fill text-warning"></i> {{ number_format($mitra->rata_rating, 1) }}</span>
                                <small class="text-muted">({{ $mitra->jumlah_rating }})</small>
                            @else
                                <span class="text-muted">Belum ada</span>
                            @endif
                        </td>
                        <td>
                            @if ($mitra->status_mitra === 'aktif')
                                <span class="badge rounded-pill bg-success-subtle text-success px-3 py-2"><i class="bi bi-check-circle-fill me-1" style="font-size:10px;"></i>Aktif</span>
                            @elseif ($mitra->status_mitra === 'ditolak')
                                <span class="badge rounded-pill bg-danger-subtle text-danger px-3 py-2"><i class="bi bi-x-circle-fill me-1" style="font-size:10px;"></i>Ditolak</span>
                            @else
                                <span class="badge rounded-pill bg-warning-subtle text-warning px-3 py-2"><i class="bi bi-clock-fill me-1" style="font-size:10px;"></i>Menunggu Verifikasi</span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            @if ($mitra->status_mitra !== 'aktif')
                                <form action="{{ route('mitra.verify', $mitra) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-sm btn-success rounded-3"><i class="bi bi-check-lg"></i></button>
                                </form>
                            @endif
                            @if ($mitra->status_mitra !== 'ditolak')
                                <form action="{{ route('mitra.reject', $mitra) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-sm btn-outline-danger rounded-3"><i class="bi bi-x-lg"></i></button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-5">
                        <i class="bi bi-people fs-1 d-block mb-2 opacity-25"></i>
                        Belum ada mitra terdaftar.
                    </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">{{ $mitras->links('pagination::bootstrap-5') }}</div>
@endsection