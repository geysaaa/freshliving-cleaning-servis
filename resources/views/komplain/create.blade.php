@extends('layouts.pelanggan')

@section('title', 'Lapor Komplain')

@section('content')
    <div class="mx-auto" style="max-width: 500px;">
        <div class="position-relative text-center mb-4">
            <a href="{{ route('pesanan.detail', $pesanan) }}" class="position-absolute start-0 top-50 translate-middle-y text-decoration-none text-dark"><i class="bi bi-arrow-left fs-4"></i></a>
            <h3 class="mb-1">Lapor Masalah Pesanan</h3>
            <p class="text-muted mb-0">Kami akan menindaklanjuti laporanmu secepatnya</p>
        </div>

        <div class="bg-white rounded-4 shadow-sm p-4">
            <form action="{{ route('komplain.store', $pesanan) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-medium"><i class="bi bi-tag me-1"></i>Jenis Masalah</label>
                    <select name="jenis_masalah" class="form-select" required>
                        @foreach (\App\Models\Komplain::JENIS as $kode => $label)
                            <option value="{{ $kode }}" {{ old('jenis_masalah', $jenisAwal) === $kode ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('jenis_masalah') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-medium"><i class="bi bi-exclamation-triangle me-1"></i>Deskripsi Masalah</label>
                    <textarea name="deskripsi" class="form-control" rows="4" placeholder="Jelaskan masalah yang kamu alami..." required>{{ old('deskripsi') }}</textarea>
                    @error('deskripsi') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-medium"><i class="bi bi-camera me-1"></i>Foto Bukti (opsional)</label>
                    <input type="file" name="foto_bukti" class="form-control" accept="image/*">
                    @error('foto_bukti') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <button class="btn btn-danger w-100 py-2"><i class="bi bi-send me-1"></i>Kirim Komplain</button>
            </form>
        </div>
    </div>
@endsection
