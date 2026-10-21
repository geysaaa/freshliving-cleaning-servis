@extends('layouts.dashboard')

@section('title', 'Edit Paket Layanan')

@section('content')
    <div class="d-flex align-items-center gap-2 mb-4">
        <a href="{{ route('paket.index') }}" class="text-decoration-none text-dark"><i class="bi bi-arrow-left fs-4"></i></a>
        <h3 class="mb-0">Edit Paket Layanan</h3>
    </div>

    <div class="bg-white rounded-3 shadow-sm p-4" style="max-width: 600px;">
        <form action="{{ route('paket.update', $paket) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label fw-medium">Nama Paket</label>
                <input type="text" name="nama_paket" class="form-control" value="{{ old('nama_paket', $paket->nama_paket) }}" required>
                @error('nama_paket') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-medium">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi', $paket->deskripsi) }}</textarea>
            </div>
            <div class="mb-3">
    <label class="form-label fw-medium">Detail Layanan (opsional)</label>
    <textarea name="detail_layanan" class="form-control" rows="4">{{ old('detail_layanan', $paket->detail_layanan) }}</textarea>
    <small class="text-muted">Tulis satu item per baris — akan otomatis ditampilkan sebagai checklist ke pelanggan.</small>
</div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-medium">Harga (Rp)</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" name="harga" class="form-control" value="{{ old('harga', $paket->harga) }}" required min="0">
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-medium">Estimasi Durasi</label>
                    <div class="input-group">
                        <input type="number" name="estimasi_durasi_menit" class="form-control" value="{{ old('estimasi_durasi_menit', $paket->estimasi_durasi_menit) }}" required min="1">
                        <span class="input-group-text">menit</span>
                    </div>
                </div>
            </div>

            <div class="form-check form-switch mb-3">
                <input type="hidden" name="aktif" value="0">
                <input type="checkbox" name="aktif" value="1" class="form-check-input" id="aktifCheck" role="switch" {{ $paket->aktif ? 'checked' : '' }}>
                <label class="form-check-label" for="aktifCheck">Tampilkan paket ini di katalog</label>
            </div>
            <div class="mb-3">
    <label class="form-label fw-medium">Kategori</label>
    <select name="kategori" class="form-select" required>
        <option value="rumah" {{ $paket->kategori === 'rumah' ? 'selected' : '' }}>Rumah</option>
        <option value="kantor" {{ $paket->kategori === 'kantor' ? 'selected' : '' }}>Kantor</option>
        <option value="spesial" {{ $paket->kategori === 'spesial' ? 'selected' : '' }}>Spesial</option>
    </select>
</div>

            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-primary px-4"><i class="bi bi-check-lg me-1"></i>Simpan Perubahan</button>
                <a href="{{ route('paket.index') }}" class="btn btn-outline-secondary px-4">Batal</a>
            </div>
        </form>
    </div>
@endsection