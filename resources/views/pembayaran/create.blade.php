@extends('layouts.pelanggan')

@section('title', 'Pembayaran')

@section('content')
    <div class="mx-auto" style="max-width: 500px;">
        <div class="position-relative text-center mb-4">
            <a href="{{ route('pesanan.detail', $pesanan) }}" class="position-absolute start-0 top-50 translate-middle-y text-decoration-none text-dark"><i class="bi bi-arrow-left fs-4"></i></a>
            <h3 class="mb-0">Pembayaran Pesanan #{{ $pesanan->id }}</h3>
        </div>

        <div class="bg-white rounded-4 shadow-sm p-4">
            <h6 class="mb-1 fw-bold">Total Tagihan</h6>
            <h3 class="text-primary fw-bold mb-4">Rp{{ number_format($pesanan->total_tagihan, 0, ',', '.') }}</h3>

            @if ($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif

            <form action="{{ route('pembayaran.store', $pesanan) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <label class="form-label fw-medium mb-2">Pilih Metode Pembayaran</label>
                <div class="d-flex gap-2 mb-3">
                    <label class="flex-fill border rounded-3 p-3 text-center metode-option" style="cursor:pointer;">
                        <input type="radio" name="metode_pembayaran" value="transfer" class="d-none metode-radio" checked onchange="toggleMetode()">
                        <i class="bi bi-bank fs-3 d-block mb-1"></i>
                        <span class="fw-medium">Transfer Bank</span>
                    </label>
                    <label class="flex-fill border rounded-3 p-3 text-center metode-option" style="cursor:pointer;">
                        <input type="radio" name="metode_pembayaran" value="cod" class="d-none metode-radio" onchange="toggleMetode()">
                        <i class="bi bi-cash-coin fs-3 d-block mb-1"></i>
                        <span class="fw-medium">Bayar di Tempat (COD)</span>
                    </label>
                </div>

                <div id="bagianTransfer">
                    <div class="bg-light rounded-3 p-3 mb-3">
                        <small class="text-muted d-block mb-1">Transfer ke rekening:</small>
                        <div class="fw-bold">BCA - 1234567890</div>
                        <div class="text-muted">a.n. FreshLiving Cleaning Services Indonesia</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">Upload Bukti Transfer</label>
                        <input type="file" name="bukti_transfer" class="form-control" accept="image/*">
                    </div>
                </div>

                <div id="bagianCod" class="d-none">
                    <div class="alert alert-info small">
                        <i class="bi bi-info-circle me-1"></i>
                        Siapkan uang tunai sejumlah <strong>Rp{{ number_format($pesanan->total_tagihan, 0, ',', '.') }}</strong> saat mitra datang mengerjakan.
                    </div>
                </div>

                <button class="btn btn-primary w-100 py-2 mt-2"><i class="bi bi-check-lg me-1"></i>Konfirmasi Metode Pembayaran</button>
            </form>
        </div>
    </div>

    <style>
        label.metode-option:has(.metode-radio:checked) { border-color: #0d6efd !important; background: rgba(13,110,253,0.05); color: #0d6efd; }
    </style>
    <script>
        function toggleMetode() {
            var cod = document.querySelector('input[value="cod"]').checked;
            document.getElementById('bagianTransfer').classList.toggle('d-none', cod);
            document.getElementById('bagianCod').classList.toggle('d-none', !cod);
            document.querySelector('input[name="bukti_transfer"]').required = !cod;
        }
        toggleMetode();
    </script>
@endsection