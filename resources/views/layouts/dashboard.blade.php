<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'FreshLiving')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background: #f8f9fa; font-family: 'Plus Jakarta Sans', sans-serif; }
        .sidebar { width: 240px; min-height: 100vh; background: #1f4e79; color: #fff; position: fixed; top: 0; left: 0; bottom: 0; transition: left 0.2s; z-index: 1030; }
        .sidebar .brand { padding: 1.25rem 1.25rem 1rem; border-bottom: 1px solid rgba(255,255,255,0.15); font-weight: 600; font-size: 1.1rem; display: flex; align-items: center; gap: 8px; }
        .sidebar .nav-link { color: rgba(255,255,255,0.8); padding: 0.65rem 1.25rem; display: flex; align-items: center; gap: 10px; border-radius: 0; transition: all 0.15s ease; }
        .sidebar .nav-link:hover { background: rgba(255,255,255,0.08); color: #fff; }
        .sidebar .nav-link.active { background: rgba(255,255,255,0.15); color: #fff; font-weight: 500; }
        .main-content { margin-left: 240px; padding: 2rem; min-height: 100vh; }
        .btn { transition: all 0.15s ease; }
        .btn:hover { transform: translateY(-1px); }
        .mobile-topbar { display: none; }
        .sidebar-overlay { display: none; }
        @media (max-width: 768px) {
            .sidebar { left: -240px; }
            .sidebar.show { left: 0; }
            .main-content { margin-left: 0; padding: 1rem; padding-top: 4.5rem; }
            .mobile-topbar {
                display: flex; align-items: center; gap: 12px;
                position: fixed; top: 0; left: 0; right: 0; height: 56px;
                background: #1f4e79; color: #fff; padding: 0 1rem; z-index: 1020;
            }
            .sidebar-overlay.show {
                display: block; position: fixed; inset: 0; background: rgba(0,0,0,0.4); z-index: 1025;
            }
        }

        /* ===== Perbaikan tampilan HP ===== */
body { overflow-x: hidden; }
img { max-width: 100%; height: auto; }

@media (max-width: 768px) {
    .main-content h3 { font-size: 1.3rem; }

    /* tabel boleh digeser ke samping, tidak terpotong */
    .main-content .overflow-hidden { overflow-x: auto !important; -webkit-overflow-scrolling: touch; }
    .main-content .overflow-hidden > table { min-width: 620px; }

    /* kotak pencarian: ikon dan kolom ketik tetap satu baris */
    .main-content .input-group { flex-wrap: nowrap; }
    .main-content .input-group > .form-control { min-width: 0; }

    /* form filter biasa: boleh turun ke baris baru kalau tidak muat */
    .main-content form.d-flex { flex-wrap: wrap; }
    .main-content form.d-flex > .form-control,
    .main-content form.d-flex > .form-select { flex: 1 1 140px; min-width: 0; max-width: 100% !important; }

    /* form filter tanggal: selalu satu baris, tombol Filter tidak turun */
    .main-content form.d-flex:has(input[type="date"]) { width: 100%; flex-wrap: nowrap; }
    .main-content form.d-flex:has(input[type="date"]) > .form-control { flex: 1 1 0; min-width: 0; padding-left: .5rem; padding-right: .25rem; font-size: 13px; }
    .main-content form.d-flex:has(input[type="date"]) > .btn { flex: 0 0 auto; white-space: nowrap; }
}
    </style>
</head>
<body>

<div class="mobile-topbar">
    <button class="btn btn-sm btn-outline-light" onclick="document.getElementById('sidebar').classList.toggle('show'); document.getElementById('overlay').classList.toggle('show');">
        <i class="bi bi-list fs-5"></i>
    </button>
    <span class="fw-semibold"><i class="bi bi-droplet-fill"></i> FreshLiving</span>
</div>

<div class="sidebar-overlay" id="overlay" onclick="document.getElementById('sidebar').classList.remove('show'); this.classList.remove('show');"></div>

<div class="sidebar" id="sidebar">
    <div class="brand">
        <i class="bi bi-droplet-fill fs-5"></i>
        <div style="line-height:1.15;">
            FreshLiving
            <div style="font-size:10px; font-weight:400; opacity:0.7;">Cleaning Services</div>
        </div>
    </div>
    <nav class="nav flex-column mt-2">

        @if (auth()->user()->role === 'admin')
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"><i class="bi bi-house"></i> Dashboard</a>
            <a href="{{ route('transaksi.index') }}" class="nav-link {{ request()->routeIs('transaksi.*') ? 'active' : '' }}"><i class="bi bi-card-checklist"></i> Data Pesanan</a>
            <a href="{{ route('paket.index') }}" class="nav-link {{ request()->routeIs('paket.*') ? 'active' : '' }}"><i class="bi bi-box-seam"></i> Paket Layanan</a>
            <a href="{{ route('mitra.index') }}" class="nav-link {{ request()->routeIs('mitra.index') || request()->routeIs('mitra.detail') ? 'active' : '' }}"><i class="bi bi-people"></i> Data Mitra</a>
            <a href="{{ route('laporan.index') }}" class="nav-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}"><i class="bi bi-graph-up"></i> Laporan</a>
            <a href="{{ route('komplain.index') }}" class="nav-link {{ request()->routeIs('komplain.index') ? 'active' : '' }}"><i class="bi bi-exclamation-circle"></i> Komplain</a>
        @elseif (auth()->user()->role === 'mitra')
            <a href="{{ route('pesanan.masuk') }}" class="nav-link {{ request()->routeIs('pesanan.masuk') ? 'active' : '' }}"><i class="bi bi-inbox"></i> Pesanan Masuk</a>
            <a href="{{ route('pesanan.tugasSaya') }}" class="nav-link {{ request()->routeIs('pesanan.tugasSaya') ? 'active' : '' }}"><i class="bi bi-list-check"></i> Tugas Saya</a>
            <a href="{{ route('mitra.jadwal') }}" class="nav-link {{ request()->routeIs('mitra.jadwal') ? 'active' : '' }}"><i class="bi bi-calendar-week"></i> Jadwal Saya</a>
            <a href="{{ route('mitra.riwayat') }}" class="nav-link {{ request()->routeIs('mitra.riwayat') ? 'active' : '' }}"><i class="bi bi-clock-history"></i> Riwayat & Pendapatan</a>
        @endif

        <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}"><i class="bi bi-gear"></i> Pengaturan</a>
    </nav>

    <div class="mt-auto p-3" style="position:absolute; bottom:0; width:100%; border-top:1px solid rgba(255,255,255,0.15);">
        <div class="d-flex align-items-center gap-2 mb-2 pt-2">
            <div class="bg-white bg-opacity-25 text-white rounded-circle d-flex align-items-center justify-content-center fw-semibold" style="width:36px;height:36px;flex-shrink:0;">
                {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
            </div>
            <div class="text-truncate">
                <div class="text-white fw-medium text-truncate" style="font-size:14px;">{{ auth()->user()->name }}</div>
                <div class="text-white-50 text-capitalize" style="font-size:12px;">{{ auth()->user()->role }}</div>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-light w-100"><i class="bi bi-box-arrow-right me-1"></i>Logout</button>
        </form>
    </div>
</div>

<div class="main-content">
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @yield('content')
</div>

</body>
</html>
