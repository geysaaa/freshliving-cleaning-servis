@extends('layouts.dashboard')

@section('title', 'Manajemen Komplain')

@section('content')
    <div class="d-flex align-items-center gap-2 mb-1">
        <a href="javascript:history.back()" class="text-decoration-none text-dark"><i class="bi bi-arrow-left fs-4"></i></a>
        <h3 class="mb-0">Manajemen Komplain</h3>
    </div>
    <p class="text-muted mb-4">Total {{ $komplains->total() }} komplain</p>

    @php
        $badgeColor = ['baru' => 'danger', 'diproses' => 'warning', 'selesai' => 'success'];
    @endphp

    <form method="GET" class="d-flex gap-2 mb-3 flex-wrap">
        <div class="input-group" style="max-width:350px;">
            <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
            <input type="text" name="cari" class="form-control border-start-0" placeholder="Cari nama pelanggan..." value="{{ request('cari') }}">
        </div>
        <select name="status" class="form-select" style="max-width:200px;" onchange="this.form.submit()">
            <option value="">Semua Status</option>
            <option value="baru" {{ request('status') === 'baru' ? 'selected' : '' }}>Baru</option>
            <option value="diproses" {{ request('status') === 'diproses' ? 'selected' : '' }}>Diproses</option>
            <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
        </select>
        <button class="btn btn-outline-secondary">Cari</button>
    </form>

    @forelse ($komplains as $komplain)
        <div class="bg-white rounded-4 shadow-sm p-4 mb-3">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="d-flex align-items-center gap-2">
                    <span class="rounded-circle d-flex align-items-center justify-content-center fw-semibold" style="width:38px;height:38px; background:rgba(220,53,69,0.1); color:#dc3545;">
                        {{ strtoupper(substr($komplain->pelanggan->name ?? '?', 0, 1)) }}
                    </span>
                    <div>
                        <div class="fw-medium">{{ $komplain->pelanggan->name ?? '-' }}</div>
                        <small class="text-muted">Pesanan #{{ $komplain->pesanan_id }} • {{ $komplain->created_at->format('d M Y, H:i') }}</small>
                    </div>
                </div>
                <span class="badge rounded-pill bg-{{ $badgeColor[$komplain->status] ?? 'secondary' }}-subtle text-{{ $badgeColor[$komplain->status] ?? 'secondary' }} px-3 py-2">
                    {{ ucfirst($komplain->status) }}
                </span>
            </div>
            <p class="mb-3">{{ $komplain->deskripsi }}</p>

            @if ($komplain->foto_bukti)
                <a href="{{ asset('storage/' . $komplain->foto_bukti) }}" target="_blank">
                    <img src="{{ asset('storage/' . $komplain->foto_bukti) }}" class="rounded-3 mb-3" style="max-height:180px; max-width:100%; object-fit:cover;">
                </a>
            @endif

            <form action="{{ route('komplain.update', $komplain) }}" method="POST" class="d-flex gap-2 flex-wrap">
                @csrf @method('PATCH')
                <select name="status" class="form-select w-auto">
                    <option value="baru" {{ $komplain->status === 'baru' ? 'selected' : '' }}>Baru</option>
                    <option value="diproses" {{ $komplain->status === 'diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="selesai" {{ $komplain->status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
                <input type="text" name="tanggapan_admin" class="form-control" placeholder="Tanggapan..." value="{{ $komplain->tanggapan_admin }}" style="max-width:300px;">
                <button class="btn btn-primary btn-sm px-3">Simpan</button>
            </form>
        </div>
    @empty
        <div class="bg-white rounded-4 shadow-sm text-center text-muted py-5">
            <i class="bi bi-emoji-smile fs-1 d-block mb-2 opacity-25"></i>
            Tidak ada komplain.
        </div>
    @endforelse

    <div class="mt-3">{{ $komplains->links('pagination::bootstrap-5') }}</div>
@endsection