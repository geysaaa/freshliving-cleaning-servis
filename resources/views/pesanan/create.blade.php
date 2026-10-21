@extends('layouts.pelanggan')

@section('title', 'Pesan Layanan Cleaning')

@section('content')
    <div class="mx-auto" style="max-width: 600px;">
        <div class="position-relative text-center mb-4">
            <a href="{{ route('pesanan.katalog') }}" class="position-absolute start-0 top-50 translate-middle-y text-decoration-none text-dark"><i class="bi bi-arrow-left fs-4"></i></a>
            <h3 class="mb-0">Pesan Layanan Cleaning</h3>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white p-4 rounded-4 shadow-sm">
            <form action="{{ route('pesanan.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-medium"><i class="bi bi-box-seam me-1"></i>Pilih Paket Layanan</label>
                    <select name="paket_layanan_id" class="form-select" required>
                        <option value="">-- Pilih Paket --</option>
                        @foreach ($paketLayanans as $paket)
                            <option value="{{ $paket->id }}" {{ request('paket_layanan_id') == $paket->id ? 'selected' : '' }}>
                                {{ $paket->nama_paket }} - Rp{{ number_format($paket->harga, 0, ',', '.') }} ({{ $paket->estimasi_durasi_menit }} menit)
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-medium"><i class="bi bi-geo-alt me-1"></i>Alamat Lengkap</label>
                    <textarea name="alamat" class="form-control" rows="2" placeholder="Jalan, nomor rumah, patokan..." required>{{ old('alamat') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-medium"><i class="bi bi-chat-left-text me-1"></i>Catatan Tambahan (opsional)</label>
                    <textarea name="catatan_tambahan" class="form-control" rows="2" placeholder="Misal: area prioritas, akses masuk rumah...">{{ old('catatan_tambahan') }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-medium"><i class="bi bi-calendar-event me-1"></i>Tanggal & Jam Kedatangan</label>
                    <input type="datetime-local" name="jadwal" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2"><i class="bi bi-check-circle me-1"></i>Pesan Sekarang</button>
            </form>
        </div>
    </div>
@endsection