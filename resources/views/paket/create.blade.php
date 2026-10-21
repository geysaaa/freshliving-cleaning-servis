@extends('layouts.dashboard')

@section('title', 'Tambah Paket Layanan')

@section('content')
    <div class="d-flex align-items-center gap-2 mb-4">
        <a href="{{ route('paket.index') }}" class="text-decoration-none text-dark"><i class="bi bi-arrow-left fs-4"></i></a>
        <h3 class="mb-0">Tambah Paket Layanan</h3>
    </div>

    <div class="bg-white rounded-3 shadow-sm p-4" style="max-width: 600px;">
        <form action="{{ route('paket.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-medium">Nama Paket</label>
                <input type="text" name="nama_paket" class="form-control" placeholder="Contoh: General Cleaning 2 Kamar" value="{{ old('nama_paket') }}" required>
                @error('nama_paket') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="mb-3">
    <label class="form-label fw-medium">Kategori</label>
    <select name="kategori" class="form-select" required>
        <option value="rumah">Rumah</option>
        <option value="kantor">Kantor</option>
        <option value="spesial">Spesial</option>
    </select>
</div>

            <div class="mb-3">
                <label class="form-label fw-medium">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="3" placeholder="Jelaskan cakupan layanan ini...">{{ old('deskripsi') }}</textarea>
            </div>
            <div class="mb-3">
    <label class="form-label fw-medium">Detail Layanan (opsional)</label>
    <textarea name="detail_layanan" class="form-control" rows="4" placeholder="Tulis satu item per baris, contoh:&#10;Menyapu dan mengepel seluruh ruangan&#10;Membersihkan kaca jendela&#10;Membersihkan kamar mandi">{{ old('detail_layanan') }}</textarea>
    <small class="text-muted">Tulis satu item per baris — akan otomatis ditampilkan sebagai checklist ke pelanggan.</small>
</div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-medium">Harga (Rp)</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" name="harga" class="form-control" value="{{ old('harga') }}" required min="0">
                    </div>
                    @error('harga') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-medium">Estimasi Durasi</label>
                    <div class="input-group">
                        <input type="number" name="estimasi_durasi_menit" class="form-control" value="{{ old('estimasi_durasi_menit') }}" required min="1">
                        <span class="input-group-text">menit</span>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-primary px-4"><i class="bi bi-check-lg me-1"></i>Simpan</button>
                <a href="{{ route('paket.index') }}" class="btn btn-outline-secondary px-4">Batal</a>
            </div>
        </form>
    </div>
@endsection