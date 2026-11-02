<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nota Pesanan #{{ $pesanan->id }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background: #f0f2f5; font-family: 'Segoe UI', sans-serif; }
        .nota-box { max-width: 650px; margin: 2rem auto; background: #fff; border-radius: 12px; padding: 2.5rem; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        @media (max-width: 576px) {
            .nota-box { margin: 0; border-radius: 0; padding: 1.25rem; }
            .nota-box table { font-size: 13px; }
        }
        @media print {
            body { background: #fff; }
            .no-print { display: none !important; }
            .nota-box { box-shadow: none; margin: 0; max-width: 100%; }
        }
    </style>
</head>
<body>

    <div class="text-center no-print py-3">
        <button onclick="window.print()" class="btn btn-primary"><i class="bi bi-printer me-1"></i>Cetak / Simpan PDF</button>
        <a href="{{ route('pesanan.detail', $pesanan) }}" class="btn btn-outline-secondary">Kembali</a>
    </div>

    <div class="nota-box">
        <div class="d-flex justify-content-between align-items-start mb-4 pb-3 border-bottom">
            <div>
                <h4 class="fw-bold mb-0 text-primary"><i class="bi bi-droplet-fill"></i> FreshLiving</h4>
                <small class="text-muted">Jasa Cleaning Service Panggilan</small>
            </div>
            <div class="text-end">
                <h5 class="fw-bold mb-0">Bukti Pembayaran</h5>
                <small class="text-muted">Payment Receipt</small>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-6">
                <small class="text-muted d-block">No. Pesanan</small>
                <div class="fw-medium">#{{ str_pad($pesanan->id, 8, '0', STR_PAD_LEFT) }}</div>
            </div>
            <div class="col-6 text-end">
                <small class="text-muted d-block">Tgl. Pemesanan</small>
                <div class="fw-medium">{{ $pesanan->created_at->translatedFormat('l, d M Y') }}</div>
            </div>
            <div class="col-6 mt-2">
                <small class="text-muted d-block">Nama Pemesan</small>
                <div class="fw-medium">{{ $pesanan->pelanggan->name ?? '-' }}</div>
            </div>
            <div class="col-6 mt-2 text-end">
                <small class="text-muted d-block">Email</small>
                <div class="fw-medium" style="word-break: break-all;">{{ $pesanan->pelanggan->email ?? '-' }}</div>
            </div>
        </div>

        <hr>

        <h6 class="fw-bold mb-3">Info Pembayaran</h6>
        <div class="row mb-4">
            <div class="col-6">
                <small class="text-muted d-block">Tanggal Pembayaran</small>
                <div class="fw-medium">{{ $pesanan->updated_at->translatedFormat('l, d M Y') }}</div>
            </div>
            <div class="col-6 text-end">
                <small class="text-muted d-block">Metode Pembayaran</small>
                <div class="fw-medium">
                    {{ $pesanan->metode_pembayaran === 'cod' ? 'Bayar di Tempat (COD)' : 'Transfer Bank' }}
                </div>
            </div>
            <div class="col-6 mt-2">
                <small class="text-muted d-block">Total Pembayaran</small>
                <div class="fw-bold">Rp{{ number_format($pesanan->total_tagihan, 0, ',', '.') }}</div>
            </div>
            <div class="col-6 mt-2 text-end">
                <small class="text-muted d-block">Status</small>
                <div>
                    @if ($pesanan->status_pembayaran === 'lunas')
                        <span class="badge bg-success">Lunas</span>
                    @elseif ($pesanan->status_pembayaran === 'menunggu_verifikasi')
                        <span class="badge bg-warning text-dark">Menunggu Verifikasi</span>
                    @else
                        <span class="badge bg-secondary">Belum Bayar</span>
                    @endif
                </div>
            </div>
        </div>

        <hr>

        <h6 class="fw-bold mb-3">Detail Pembayaran</h6>
        <div class="table-responsive">
            <table class="table table-borderless mb-0">
                <thead>
                    <tr class="border-bottom">
                        <th>Keterangan</th>
                        <th class="text-center">Jumlah</th>
                        <th class="text-end">Satuan</th>
                        <th class="text-end">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $pesanan->paketLayanan->nama_paket }} - {{ $pesanan->jadwal->format('d M Y') }}</td>
                        <td class="text-center">1</td>
                        <td class="text-end">Rp{{ number_format($pesanan->total_tagihan, 0, ',', '.') }}</td>
                        <td class="text-end">Rp{{ number_format($pesanan->total_tagihan, 0, ',', '.') }}</td>
                    </tr>
                    <tr class="border-top">
                        <td colspan="3" class="text-end fw-bold pt-3">Total Dibayar</td>
                        <td class="text-end fw-bold pt-3">Rp{{ number_format($pesanan->total_tagihan, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="mt-4 pt-3 border-top text-end">
            <small class="text-muted d-block">Jakarta, {{ now()->translatedFormat('d F Y') }}</small>
            <p class="mb-0 mt-1">Hormat Kami,</p>
            <p class="fw-bold mt-4">PT FreshLiving Indonesia</p>
        </div>

        <div class="text-center mt-4 pt-3 border-top">
            <small class="text-muted">Terima kasih telah memesan di FreshLiving. Dokumen ini adalah bukti pembayaran resmi yang diterbitkan secara elektronik.</small>
        </div>
    </div>

</body>
</html>
