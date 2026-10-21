@extends('layouts.pelanggan')

@section('title', 'Lacak Pesanan')

@section('content')
    <div class="mx-auto" style="max-width: 600px;">
        <div class="position-relative text-center mb-4">
            <a href="{{ route('pesanan.riwayat') }}" class="position-absolute start-0 top-50 translate-middle-y text-decoration-none text-dark"><i class="bi bi-arrow-left fs-4"></i></a>
            <h3 class="mb-0">Lacak Pesanan #{{ $pesanan->id }}</h3>
        </div>

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @php
            $steps = ['dikonfirmasi' => 'Dikonfirmasi', 'menuju_lokasi' => 'Menuju Lokasi', 'sedang_mengerjakan' => 'Sedang Dikerjakan', 'selesai' => 'Selesai'];
            $stepKeys = array_keys($steps);
            $currentIndex = array_search($pesanan->status, $stepKeys);
            if ($currentIndex === false) $currentIndex = -1;
            $bisaBatal = in_array($pesanan->status, ['menunggu_mitra', 'dikonfirmasi'])
                && $pesanan->status_pembayaran === 'belum_bayar';
        @endphp

        <div class="bg-white rounded-4 shadow-sm p-4 mb-3">
            @if ($pesanan->status === 'dibatalkan')
                <div class="text-center py-3">
                    <i class="bi bi-x-circle-fill text-danger" style="font-size:2.5rem;"></i>
                    <p class="mb-0 mt-2 fw-medium">Pesanan ini telah dibatalkan.</p>
                </div>
            @elseif ($pesanan->status === 'menunggu_mitra')
                <div class="text-center py-3">
                    <div class="spinner-border text-primary mb-3" role="status"></div>
                    <p class="mb-0 fw-medium">Sedang mencari mitra terdekat untukmu...</p>
                </div>
            @else
                <div class="d-flex justify-content-between position-relative mb-2">
                    <div class="position-absolute top-50 start-0 end-0 translate-middle-y" style="height:3px; background:#e9ecef; z-index:0;"></div>
                    <div class="position-absolute top-50 start-0 translate-middle-y" style="height:3px; background:#0d6efd; width:{{ $currentIndex >= 0 ? ($currentIndex / (count($steps)-1)) * 100 : 0 }}%; z-index:1;"></div>
                    @foreach ($steps as $key => $label)
                        @php $stepIndex = array_search($key, $stepKeys); @endphp
                        <div class="text-center position-relative" style="z-index:2; flex:1;">
                            <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center
                                {{ $stepIndex <= $currentIndex ? 'bg-primary text-white' : 'bg-white border' }}"
                                style="width:32px;height:32px;">
                                @if ($stepIndex < $currentIndex || $pesanan->status === 'selesai' && $stepIndex <= $currentIndex)
                                    <i class="bi bi-check-lg"></i>
                                @else
                                    {{ $stepIndex + 1 }}
                                @endif
                            </div>
                            <small class="d-block mt-1" style="font-size:11px;">{{ $label }}</small>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="bg-white rounded-4 shadow-sm p-4">
            <h6 class="mb-3 fw-bold">Detail Pesanan</h6>

            <div class="d-flex justify-content-between py-2 border-bottom">
                <span class="text-muted">Paket</span>
                <span class="fw-medium">{{ $pesanan->paketLayanan->nama_paket }}</span>
            </div>
            <div class="d-flex justify-content-between py-2 border-bottom">
                <span class="text-muted">Jadwal</span>
                <span class="fw-medium">{{ $pesanan->jadwal->format('d M Y, H:i') }}</span>
            </div>
            <div class="d-flex justify-content-between py-2 border-bottom">
                <span class="text-muted">Alamat</span>
                <span class="fw-medium text-end" style="max-width:60%;">{{ $pesanan->alamat }}</span>
            </div>
            <div class="d-flex justify-content-between py-2 border-bottom">
                <span class="text-muted">Mitra</span>
                <span class="fw-medium">
                    {{ $pesanan->mitra->name ?? 'Belum ditugaskan' }}
                    @if ($pesanan->mitra)
                        @php
                            $ratingMitra = \App\Models\Rating::whereHas('pesanan', fn($q) => $q->where('mitra_id', $pesanan->mitra->id))->avg('rating');
                        @endphp
                        @if ($ratingMitra)
                            <span class="text-warning ms-1"><i class="bi bi-star-fill"></i> {{ number_format($ratingMitra, 1) }}</span>
                        @endif
                    @endif
                </span>
            </div>
            <div class="d-flex justify-content-between py-2 border-bottom">
                <span class="text-muted">Total Tagihan</span>
                <span class="fw-bold text-primary">Rp{{ number_format($pesanan->total_tagihan, 0, ',', '.') }}</span>
            </div>
            <div class="d-flex justify-content-between py-2">
                <span class="text-muted">Status Pembayaran</span>
                <span>
                    @if ($pesanan->status_pembayaran === 'lunas')
                        <span class="badge bg-success-subtle text-success px-3 py-2">Lunas</span>
                    @elseif ($pesanan->status_pembayaran === 'menunggu_verifikasi')
                        <span class="badge bg-warning-subtle text-warning px-3 py-2">Menunggu Verifikasi</span>
                    @else
                        <span class="badge bg-danger-subtle text-danger px-3 py-2">Belum Bayar</span>
                    @endif
                </span>
            </div>

            @if ($pesanan->status !== 'dibatalkan' && $pesanan->status_pembayaran === 'belum_bayar' && !$pesanan->metode_pembayaran)
                <a href="{{ route('pembayaran.create', $pesanan) }}" class="btn btn-primary btn-sm mt-2 w-100"><i class="bi bi-credit-card me-1"></i>Bayar Sekarang</a>
            @endif
            @if ($pesanan->metode_pembayaran && $pesanan->status !== 'dibatalkan')
                <a href="{{ route('pembayaran.nota', $pesanan) }}" target="_blank" class="btn btn-outline-secondary btn-sm mt-2 w-100"><i class="bi bi-receipt me-1"></i>Lihat/Cetak Nota</a>
            @endif

            {{-- Rating, Komplain, Batalkan --}}
            <div class="mt-3">
                @if ($pesanan->status === 'selesai' && $pesanan->rating)
                    <div class="p-3 bg-light rounded-3 mb-2 text-center">
                        <small class="text-muted d-block mb-1">Rating yang kamu beri:</small>
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="bi bi-star{{ $i <= $pesanan->rating->rating ? '-fill text-warning' : ' text-muted' }}"></i>
                        @endfor
                        @if ($pesanan->rating->ulasan)
                            <p class="mb-0 mt-2 fst-italic">"{{ $pesanan->rating->ulasan }}"</p>
                        @endif
                    </div>
                @endif

                <div class="d-flex gap-2 flex-wrap">
                    @if ($pesanan->status === 'selesai' && !$pesanan->rating)
                        <a href="{{ route('rating.create', $pesanan) }}" class="btn btn-primary flex-fill"><i class="bi bi-star me-1"></i>Beri Rating</a>
                    @endif
                    @if ($pesanan->status !== 'dibatalkan')
                        <a href="{{ route('komplain.create', $pesanan) }}" class="btn btn-outline-danger flex-fill"><i class="bi bi-exclamation-triangle me-1"></i>Lapor Komplain</a>
                    @endif
                    @if ($bisaBatal)
                        <form action="{{ route('pesanan.batalkan', $pesanan) }}" method="POST" class="flex-fill"
                              onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                            @csrf
                            <button class="btn btn-danger w-100"><i class="bi bi-x-circle me-1"></i>Batalkan Pesanan</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection