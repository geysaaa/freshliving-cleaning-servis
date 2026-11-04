@extends('layouts.dashboard')

@section('title', 'Data Paket Layanan')

@section('content')
    <div class="d-flex align-items-center gap-2 mb-1">
        <a href="javascript:history.back()" class="text-decoration-none text-dark"><i class="bi bi-arrow-left fs-4"></i></a>
        <h3 class="mb-0">Data Paket Layanan</h3>
    </div>
    <div class="d-flex justify-content-between align-items-center gap-2 mb-4">
        <p class="text-muted mb-0">Total {{ $paketLayanans->total() }} paket terdaftar</p>
        <a href="{{ route('paket.create') }}" class="btn btn-primary btn-sm text-nowrap"><i class="bi bi-plus-lg me-1"></i>Tambah Paket</a>
    </div>

    <form method="GET" class="mb-3">
        <div class="input-group" style="max-width:400px;">
            <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
            <input type="text" name="cari" class="form-control" placeholder="Cari nama paket..." value="{{ request('cari') }}">
            <button class="btn btn-outline-secondary">Cari</button>
        </div>
    </form>

    {{-- TAMPILAN LAPTOP: tabel --}}
    <div class="bg-white rounded-4 shadow-sm overflow-hidden d-none d-md-block">
        <table class="table table-hover mb-0 align-middle">
            <thead style="background:#f1f3f5;">
                <tr>
                    <th class="ps-3">Nama Paket</th>
                    <th>Harga</th>
                    <th>Estimasi Durasi</th>
                    <th>Status</th>
                    <th class="text-end pe-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($paketLayanans as $paket)
                    <tr>
                        <td class="ps-3">
                            <div class="d-flex align-items-center gap-2">
                                <span class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width:36px;height:36px;">
                                    <i class="bi bi-box-seam"></i>
                                </span>
                                <div>
                                    <div class="fw-semibold">{{ $paket->nama_paket }}</div>
                                    <small class="text-muted">{{ Str::limit($paket->deskripsi, 40) }}</small>
                                </div>
                            </div>
                        </td>
                        <td class="fw-semibold">Rp{{ number_format($paket->harga, 0, ',', '.') }}</td>
                        <td>{{ $paket->estimasi_durasi_menit }} menit</td>
                        <td>
                            @if ($paket->aktif)
                                <span class="badge rounded-pill bg-success-subtle text-success px-3 py-2">Aktif</span>
                            @else
                                <span class="badge rounded-pill bg-secondary-subtle text-secondary px-3 py-2">Nonaktif</span>
                            @endif
                        </td>
                        <td class="text-end pe-3">
                            <a href="{{ route('paket.edit', $paket) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('paket.destroy', $paket) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus paket ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">Belum ada paket layanan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- TAMPILAN HP: kartu --}}
    <div class="d-md-none">
        @forelse ($paketLayanans as $paket)
            <div class="bg-white rounded-4 shadow-sm p-3 mb-3">
                <div class="d-flex justify-content-between align-items-start gap-2">
                    <div class="d-flex align-items-center gap-2" style="min-width:0;">
                        <span class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width:40px;height:40px;">
                            <i class="bi bi-box-seam"></i>
                        </span>
                        <div style="min-width:0;">
                            <div class="fw-semibold text-break">{{ $paket->nama_paket }}</div>
                            <small class="text-muted">{{ Str::limit($paket->deskripsi, 40) }}</small>
                        </div>
                    </div>
                    @if ($paket->aktif)
                        <span class="badge rounded-pill bg-success-subtle text-success px-3 py-2">Aktif</span>
                    @else
                        <span class="badge rounded-pill bg-secondary-subtle text-secondary px-3 py-2">Nonaktif</span>
                    @endif
                </div>

                <div class="d-flex justify-content-between align-items-end mt-3 pt-3 border-top">
                    <div>
                        <div class="fw-bold text-primary">Rp{{ number_format($paket->harga, 0, ',', '.') }}</div>
                        <small class="text-muted"><i class="bi bi-clock me-1"></i>{{ $paket->estimasi_durasi_menit }} menit</small>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('paket.edit', $paket) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil me-1"></i>Edit</a>
                        <form action="{{ route('paket.destroy', $paket) }}" method="POST" onsubmit="return confirm('Yakin hapus paket ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash me-1"></i>Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-4 shadow-sm text-center text-muted py-5">
                <i class="bi bi-box-seam fs-1 d-block mb-2 opacity-25"></i>
                Belum ada paket layanan.
            </div>
        @endforelse
    </div>

    <div class="mt-3">{{ $paketLayanans->links('pagination::bootstrap-5') }}</div>
@endsection
