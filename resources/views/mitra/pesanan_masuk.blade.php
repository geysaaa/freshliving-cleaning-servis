@extends('layouts.dashboard')

@section('title', 'Pesanan Masuk')

@section('content')
    <h3 class="mb-1">Pesanan Masuk</h3>
    <p class="text-muted mb-4">Pesanan baru yang sesuai jadwal dan area kamu</p>

    @forelse ($pesanans as $pesanan)
        <div class="bg-white rounded-4 shadow-sm p-4 mb-3 border-start border-4 border-primary">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                <div>
                    <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-1 mb-2">Baru</span>
                    <div class="fw-bold fs-5">{{ $pesanan->paketLayanan->nama_paket }}</div>
                    <small class="text-muted d-block mt-1"><i class="bi bi-calendar-event me-1"></i>{{ $pesanan->jadwal->format('d M Y, H:i') }}</small>
                    <small class="text-muted d-block"><i class="bi bi-cash me-1"></i>Estimasi Rp{{ number_format($pesanan->pendapatan_mitra, 0, ',', '.') }}</small>
                </div>
                <div class="d-flex gap-2">
                    <form action="{{ route('pesanan.accept', $pesanan) }}" method="POST">
                        @csrf
                        <button class="btn btn-success"><i class="bi bi-check-lg me-1"></i>Terima</button>
                    </form>
                    <form action="{{ route('pesanan.reject', $pesanan) }}" method="POST">
                        @csrf
                        <button class="btn btn-outline-danger"><i class="bi bi-x-lg me-1"></i>Tolak</button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="bg-white rounded-4 shadow-sm text-center text-muted py-5">
            <i class="bi bi-inbox fs-1 d-block mb-2 opacity-25"></i>
            Belum ada pesanan masuk.
        </div>
    @endforelse
@endsection