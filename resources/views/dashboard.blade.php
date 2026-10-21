@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
    {{-- RULE 1: Konteks pertama - filter tanggal di kiri atas --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h4 class="mb-1 fw-bold">Halo, {{ auth()->user()->name }} 👋</h4>
            <p class="text-muted mb-0">{{ now()->translatedFormat('l, d F Y') }}</p>
        </div>
        <form method="GET" class="d-flex gap-2">
            <input type="date" name="dari" class="form-control form-control-sm" value="{{ $dari->format('Y-m-d') }}">
            <input type="date" name="sampai" class="form-control form-control-sm" value="{{ $sampai->format('Y-m-d') }}">
            <button class="btn btn-sm btn-primary"><i class="bi bi-funnel"></i> Filter</button>
        </form>
    </div>

    {{-- RULE 2: Rangkuman singkat - kartu KPI --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="bg-white rounded-4 shadow-sm p-4 h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width:52px;height:52px; background:rgba(31,78,121,0.1);">
                        <i class="bi bi-box-seam fs-4 text-primary"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block">Total Paket Layanan</small>
                        <h3 class="mb-0 fw-bold">{{ $totalPaket }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="bg-white rounded-4 shadow-sm p-4 h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width:52px;height:52px; background:rgba(255,193,7,0.15);">
                        <i class="bi bi-hourglass-split fs-4 text-warning"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block">Menunggu Mitra</small>
                        <h3 class="mb-0 fw-bold">{{ $menungguMitra }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="bg-white rounded-4 shadow-sm p-4 h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width:52px;height:52px; background:rgba(13,202,240,0.15);">
                        <i class="bi bi-gear-wide-connected fs-4 text-info"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block">Sedang Dikerjakan</small>
                        <h3 class="mb-0 fw-bold">{{ $sedangDikerjakan }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="bg-white rounded-4 shadow-sm p-4 h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width:52px;height:52px; background:rgba(25,135,84,0.12);">
                        <i class="bi bi-check-circle fs-4 text-success"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block">Selesai</small>
                        <h3 class="mb-0 fw-bold">{{ $selesai }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- RULE 3: Inti cerita - grafik insight utama --}}
    <div class="bg-white rounded-4 shadow-sm p-4 mb-4">
        <h6 class="mb-3 fw-bold">Pendapatan Platform (Sesuai Filter Tanggal)</h6>
        <canvas id="grafikDashboard" height="70"></canvas>
    </div>

    {{-- RULE 4: Detail - data pendukung & breakdown kategori --}}
    <div class="row g-3 mb-4">
        <div class="col-lg-8">
            <div class="bg-white rounded-4 shadow-sm p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0 fw-bold">Pesanan Terbaru</h6>
                    <a href="{{ route('transaksi.index') }}" class="small text-decoration-none">Lihat Semua <i class="bi bi-arrow-right"></i></a>
                </div>
                @php
                    $badgeColor = ['menunggu_mitra'=>'secondary','dikonfirmasi'=>'warning','menuju_lokasi'=>'info','sedang_mengerjakan'=>'primary','selesai'=>'success','dibatalkan'=>'danger'];
                @endphp
                @forelse ($pesananTerbaru as $p)
                    <div class="d-flex justify-content-between align-items-center py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                        <div>
                            <div class="fw-medium">{{ $p->pelanggan->name ?? '-' }}</div>
                            <small class="text-muted">{{ $p->paketLayanan->nama_paket }}</small>
                        </div>
                        <span class="badge rounded-pill bg-{{ $badgeColor[$p->status] ?? 'secondary' }}-subtle text-{{ $badgeColor[$p->status] ?? 'secondary' }} px-3 py-2">
                            {{ str_replace('_',' ',$p->status) }}
                        </span>
                    </div>
                @empty
                    <p class="text-muted text-center py-4 mb-0">Belum ada pesanan.</p>
                @endforelse
            </div>
        </div>
        <div class="col-lg-4">
            <div class="bg-white rounded-4 shadow-sm p-4 h-100">
                <h6 class="mb-3 fw-bold">Breakdown Kategori</h6>
                @php
                    $kategoriLabel = ['rumah' => 'Rumah', 'kantor' => 'Kantor', 'spesial' => 'Spesial'];
                    $kategoriWarna = ['rumah' => 'primary', 'kantor' => 'success', 'spesial' => 'warning'];
                    $totalKategori = $breakdownKategori->sum();
                @endphp
                @forelse ($kategoriLabel as $key => $label)
                    @php $jumlah = $breakdownKategori[$key] ?? 0; @endphp
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <small class="fw-medium">{{ $label }}</small>
                            <small class="text-muted">{{ $jumlah }} pesanan</small>
                        </div>
                        <div class="progress" style="height:8px;">
                            <div class="progress-bar bg-{{ $kategoriWarna[$key] }}" style="width: {{ $totalKategori > 0 ? ($jumlah / $totalKategori * 100) : 0 }}%"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted small">Belum ada data.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- RULE 5: Kesimpulan - catatan aksi / insight tindak lanjut --}}
    <div class="bg-white rounded-4 shadow-sm p-4">
        <h6 class="mb-3 fw-bold"><i class="bi bi-journal-check me-1"></i>Catatan Aksi</h6>
        <div class="d-flex flex-column gap-2">
            @if ($pesananLamaMenunggu > 0)
                <a href="{{ route('transaksi.index', ['status' => 'menunggu_mitra']) }}" class="d-flex align-items-center gap-2 text-decoration-none text-dark p-2 rounded-3" style="background:rgba(255,193,7,0.08);">
                    <i class="bi bi-exclamation-triangle-fill text-warning"></i>
                    <span>{{ $pesananLamaMenunggu }} pesanan sudah menunggu mitra lebih dari 24 jam, perlu ditindaklanjuti.</span>
                </a>
            @endif
            @if ($mitraMenungguVerifikasi > 0)
                <a href="{{ route('mitra.index', ['status' => 'menunggu_verifikasi']) }}" class="d-flex align-items-center gap-2 text-decoration-none text-dark p-2 rounded-3" style="background:rgba(13,202,240,0.08);">
                    <i class="bi bi-person-check-fill text-info"></i>
                    <span>{{ $mitraMenungguVerifikasi }} mitra baru menunggu verifikasi.</span>
                </a>
            @endif
            @if ($komplainBaru > 0)
                <a href="{{ route('komplain.index') }}" class="d-flex align-items-center gap-2 text-decoration-none text-dark p-2 rounded-3" style="background:rgba(220,53,69,0.08);">
                    <i class="bi bi-exclamation-circle-fill text-danger"></i>
                    <span>{{ $komplainBaru }} komplain baru belum ditangani.</span>
                </a>
            @endif
            @if ($pesananLamaMenunggu === 0 && $mitraMenungguVerifikasi === 0 && $komplainBaru === 0)
                <div class="d-flex align-items-center gap-2 text-muted p-2">
                    <i class="bi bi-check-circle-fill text-success"></i>
                    <span>Tidak ada yang perlu ditindaklanjuti saat ini. Semua berjalan lancar!</span>
                </div>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
    <script>
        new Chart(document.getElementById('grafikDashboard'), {
            type: 'line',
            data: {
                labels: @json($grafikLabel),
                datasets: [{
                    label: 'Pendapatan Platform (Rp)',
                    data: @json($grafikData),
                    borderColor: '#1f4e79',
                    backgroundColor: 'rgba(31,78,121,0.08)',
                    fill: true,
                    tension: 0.3,
                    pointRadius: 3,
                }]
            },
            options: {
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, ticks: { callback: v => 'Rp' + v.toLocaleString('id-ID') } } }
            }
        });
    </script>
@endsection