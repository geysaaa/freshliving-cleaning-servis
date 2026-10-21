<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FreshLiving Cleaning Services - Jasa Cleaning Panggilan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        html { scroll-behavior: smooth; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; color: #1c2b39; }
        .navbar-fl { background: rgba(255,255,255,0.92); backdrop-filter: blur(8px); box-shadow: 0 1px 12px rgba(0,0,0,0.06); }
        .brand-fl { color: #1f4e79; font-weight: 800; }
        .nav-link-fl { color: #4a5b6b; font-weight: 500; }
        .nav-link-fl:hover { color: #1f4e79; }
        .hero { background: linear-gradient(160deg, #eaf2fb 0%, #ffffff 70%); padding: 5rem 0 4rem; }
        .hero h1 { font-weight: 800; font-size: clamp(2.2rem, 5vw, 3.4rem); line-height: 1.15; }
        .hero h1 span { color: #1f4e79; }
        .pill { background: rgba(31,78,121,0.08); color: #1f4e79; font-weight: 600; font-size: 13px; border-radius: 999px; padding: 6px 14px; display: inline-flex; align-items: center; gap: 6px; }
        .btn-fl { background: #1f4e79; border-color: #1f4e79; color: #fff; }
        .btn-fl:hover { background: #173b5c; border-color: #173b5c; color: #fff; }
        .mock-card { background: #fff; border-radius: 20px; box-shadow: 0 20px 50px rgba(31,78,121,0.15); padding: 1.5rem; }
        .mock-step { width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 13px; }
        .section-title { font-weight: 800; }
        .step-card, .layanan-card, .fitur-card { background: #fff; border-radius: 18px; box-shadow: 0 2px 14px rgba(0,0,0,0.05); transition: transform .2s ease, box-shadow .2s ease; }
        .step-card:hover, .layanan-card:hover, .fitur-card:hover { transform: translateY(-5px); box-shadow: 0 14px 30px rgba(31,78,121,0.12); }
        .icon-box { width: 56px; height: 56px; border-radius: 14px; background: rgba(31,78,121,0.09); color: #1f4e79; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; }
        .step-no { width: 34px; height: 34px; border-radius: 50%; background: #1f4e79; color: #fff; font-weight: 700; display: flex; align-items: center; justify-content: center; }
        .cta-band { background: linear-gradient(135deg, #1f4e79 0%, #2d6ba3 100%); border-radius: 24px; color: #fff; }
        footer { background: #12293f; color: rgba(255,255,255,0.7); }
    </style>
</head>
<body>

    {{-- NAVBAR --}}
    <nav class="navbar navbar-expand-lg navbar-fl sticky-top py-3">
        <div class="container">
            <a class="navbar-brand brand-fl d-flex align-items-center gap-2" href="#">
                <i class="bi bi-droplet-fill"></i> FreshLiving <small class="fw-medium text-muted d-none d-sm-inline" style="font-size:12px;">Cleaning Services</small>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <i class="bi bi-list fs-3"></i>
            </button>
            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav mx-auto gap-lg-3">
                    <li class="nav-item"><a class="nav-link nav-link-fl" href="#layanan">Layanan</a></li>
                    <li class="nav-item"><a class="nav-link nav-link-fl" href="#cara-kerja">Cara Kerja</a></li>
                    <li class="nav-item"><a class="nav-link nav-link-fl" href="#keunggulan">Keunggulan</a></li>
                    <li class="nav-item"><a class="nav-link nav-link-fl" href="#mitra">Jadi Mitra</a></li>
                </ul>
                <div class="d-flex gap-2">
                    <a href="{{ route('login') }}" class="btn btn-outline-secondary rounded-pill px-4">Log in</a>
                    <a href="{{ route('register') }}" class="btn btn-fl rounded-pill px-4">Register</a>
                </div>
            </div>
        </div>
    </nav>

    {{-- HERO --}}
    <section class="hero">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <span class="pill mb-3"><i class="bi bi-patch-check-fill"></i> Mitra cleaning terverifikasi</span>
                    <h1 class="mb-3">Rumah bersih, <span>tanpa ribet.</span></h1>
                    <p class="text-muted fs-5 mb-4">Pesan jasa cleaning service ke rumah atau kantormu kapan saja. Harga transparan, mitra terverifikasi, status pesanan bisa dipantau langsung.</p>
                    <div class="d-flex gap-2 flex-wrap mb-4">
                        <a href="{{ route('register') }}" class="btn btn-fl btn-lg rounded-pill px-4">Mulai Pesan Sekarang</a>
                        <a href="#cara-kerja" class="btn btn-outline-secondary btn-lg rounded-pill px-4">Lihat Cara Kerja</a>
                    </div>
                    <div class="d-flex gap-4 flex-wrap text-muted small">
                        <span><i class="bi bi-check-circle-fill text-success me-1"></i>Tanpa tawar-menawar</span>
                        <span><i class="bi bi-check-circle-fill text-success me-1"></i>Bayar Transfer atau COD</span>
                        <span><i class="bi bi-check-circle-fill text-success me-1"></i>Nota digital</span>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="mock-card mx-auto" style="max-width: 420px;">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <small class="text-muted d-block">Lacak Pesanan</small>
                                <span class="fw-bold">General Cleaning 2 Kamar</span>
                            </div>
                            <span class="badge rounded-pill bg-primary-subtle text-primary px-3 py-2">Sedang Dikerjakan</span>
                        </div>
                        <div class="d-flex justify-content-between position-relative mb-4 px-1">
                            <div class="position-absolute top-50 start-0 end-0 translate-middle-y" style="height:3px;background:#e9ecef;"></div>
                            <div class="position-absolute top-50 start-0 translate-middle-y" style="height:3px;background:#0d6efd;width:66%;"></div>
                            <div class="mock-step bg-primary text-white position-relative"><i class="bi bi-check-lg"></i></div>
                            <div class="mock-step bg-primary text-white position-relative"><i class="bi bi-check-lg"></i></div>
                            <div class="mock-step bg-primary text-white position-relative"><i class="bi bi-gear-fill"></i></div>
                            <div class="mock-step bg-white border position-relative text-muted">4</div>
                        </div>
                        <div class="d-flex justify-content-between py-2 border-top">
                            <span class="text-muted small"><i class="bi bi-person-check me-1"></i>Mitra</span>
                            <span class="small fw-medium">Mitra terverifikasi</span>
                        </div>
                        <div class="d-flex justify-content-between py-2 border-top">
                            <span class="text-muted small"><i class="bi bi-wallet2 me-1"></i>Pembayaran</span>
                            <span class="small fw-medium">Transfer / COD</span>
                        </div>
                    </div>
                    <p class="text-center text-muted mt-3 mb-0" style="font-size:12px;">Ilustrasi tampilan pelacakan pesanan</p>
                </div>
            </div>
        </div>
    </section>

    {{-- LAYANAN (dari database) --}}
    @php $pakets = \App\Models\PaketLayanan::where('aktif', true)->orderBy('harga')->take(6)->get(); @endphp
    @if ($pakets->count())
        <section id="layanan" class="py-5">
            <div class="container py-4">
                <div class="text-center mb-5">
                    <h2 class="section-title">Layanan Kami</h2>
                    <p class="text-muted">Pilih paket sesuai kebutuhan rumah atau kantormu</p>
                </div>
                @php
                    $warna = ['rumah' => 'primary', 'kantor' => 'success', 'spesial' => 'warning'];
                    $label = ['rumah' => 'Rumah', 'kantor' => 'Kantor', 'spesial' => 'Spesial'];
                @endphp
                <div class="row g-4">
                    @foreach ($pakets as $p)
                        <div class="col-md-6 col-lg-4">
                            <div class="layanan-card p-4 h-100 d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="icon-box"><i class="bi bi-house-heart"></i></div>
                                    <span class="badge rounded-pill bg-{{ $warna[$p->kategori] ?? 'primary' }}-subtle text-{{ $warna[$p->kategori] ?? 'primary' }} px-3 py-2">{{ $label[$p->kategori] ?? 'Rumah' }}</span>
                                </div>
                                <h5 class="fw-bold">{{ $p->nama_paket }}</h5>
                                <p class="text-muted small flex-grow-1">{{ $p->deskripsi }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="fw-bold fs-5" style="color:#1f4e79;">Rp{{ number_format($p->harga, 0, ',', '.') }}</div>
                                        <small class="text-muted"><i class="bi bi-clock me-1"></i>{{ $p->estimasi_durasi_menit }} menit</small>
                                    </div>
                                    <a href="{{ route('register') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">Pesan</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- CARA KERJA --}}
    <section id="cara-kerja" class="py-5" style="background:#f6f9fc;">
        <div class="container py-4">
            <div class="text-center mb-5">
                <h2 class="section-title">Cara Kerja</h2>
                <p class="text-muted">Empat langkah dari pesan sampai rumah bersih</p>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="step-card p-4 h-100">
                        <div class="step-no mb-3">1</div>
                        <h6 class="fw-bold">Pilih Paket</h6>
                        <p class="text-muted small mb-0">Pilih layanan dari katalog, lengkap dengan harga dan rincian yang dikerjakan.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="step-card p-4 h-100">
                        <div class="step-no mb-3">2</div>
                        <h6 class="fw-bold">Tentukan Jadwal</h6>
                        <p class="text-muted small mb-0">Isi alamat dan waktu kedatangan. Sistem otomatis mencarikan mitra yang tersedia.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="step-card p-4 h-100">
                        <div class="step-no mb-3">3</div>
                        <h6 class="fw-bold">Pantau Pesanan</h6>
                        <p class="text-muted small mb-0">Lihat status dari dikonfirmasi, menuju lokasi, sampai selesai dikerjakan.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="step-card p-4 h-100">
                        <div class="step-no mb-3">4</div>
                        <h6 class="fw-bold">Bayar & Beri Rating</h6>
                        <p class="text-muted small mb-0">Bayar via Transfer atau COD, dapatkan nota, lalu beri penilaian untuk mitra.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- KEUNGGULAN --}}
    <section id="keunggulan" class="py-5">
        <div class="container py-4">
            <div class="text-center mb-5">
                <h2 class="section-title">Kenapa FreshLiving?</h2>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="fitur-card p-4 h-100">
                        <div class="icon-box mb-3"><i class="bi bi-shield-check"></i></div>
                        <h5 class="fw-bold">Mitra Terverifikasi</h5>
                        <p class="text-muted mb-0">Setiap mitra melalui verifikasi identitas oleh Admin sebelum bisa menerima pesanan.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="fitur-card p-4 h-100">
                        <div class="icon-box mb-3"><i class="bi bi-cash-coin"></i></div>
                        <h5 class="fw-bold">Harga Transparan</h5>
                        <p class="text-muted mb-0">Harga sudah ditetapkan sesuai paket. Tidak ada tawar-menawar atau biaya tersembunyi.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="fitur-card p-4 h-100">
                        <div class="icon-box mb-3"><i class="bi bi-geo-alt"></i></div>
                        <h5 class="fw-bold">Lacak Real-Time</h5>
                        <p class="text-muted mb-0">Pantau status pesananmu langsung dari aplikasi, dan laporkan masalah kalau ada.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- AJAKAN JADI MITRA --}}
    <section id="mitra" class="pb-5">
        <div class="container pb-4">
            <div class="cta-band p-5 text-center">
                <h2 class="fw-bold mb-2">Punya keahlian bersih-bersih?</h2>
                <p class="mb-4 opacity-75">Gabung sebagai mitra FreshLiving, atur sendiri hari kerjamu, dan dapatkan pesanan langsung dari pelanggan.</p>
                <a href="{{ route('register') }}" class="btn btn-light btn-lg rounded-pill px-5 fw-semibold">Daftar Jadi Mitra</a>
            </div>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="py-4">
        <div class="container d-flex justify-content-between align-items-center flex-wrap gap-2">
            <span class="fw-semibold text-white"><i class="bi bi-droplet-fill me-1"></i>FreshLiving Cleaning Services</span>
            <small>&copy; {{ date('Y') }} FreshLiving. Platform jasa cleaning service panggilan.</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>