<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'FreshLiving Cleaning Services')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background: #f8f9fa; font-family: 'Plus Jakarta Sans', sans-serif; }
        .topnav { background: #1f4e79; padding: 0.75rem 1.5rem; }
        .topnav .brand { color: #fff; font-weight: 700; font-size: 1.1rem; display: flex; align-items: center; gap: 8px; }
        .topnav .nav-link { color: rgba(255,255,255,0.8); font-weight: 500; padding: 0.5rem 0.9rem; border-radius: 8px; transition: all 0.15s ease; white-space: nowrap; }
        .topnav .nav-link:hover { background: rgba(255,255,255,0.08); color: #fff; }
        .topnav .nav-link.active { background: rgba(255,255,255,0.15); color: #fff; }
        .main-content { padding: 2rem; max-width: 1200px; margin: 0 auto; }
        .btn:hover { transform: translateY(-1px); }
        .btn { transition: all 0.15s ease; }
        .user-badge { background: rgba(255,255,255,0.15); color: #fff; border-radius: 999px; padding: 6px 14px; font-size: 13px; display: flex; align-items: center; gap: 8px; }
    </style>
</head>
<body>

<nav class="topnav">
    <div class="container-fluid" style="max-width:1200px;">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-2">
            <div class="brand"><i class="bi bi-droplet-fill"></i> FreshLiving Cleaning Services</div>
            <div class="d-flex align-items-center gap-2">
                <span class="user-badge">
                    <span class="rounded-circle bg-white text-primary fw-bold d-flex align-items-center justify-content-center" style="width:24px;height:24px;font-size:12px;">
                        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                    </span>
                    {{ auth()->user()->name }}
                </span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-light"><i class="bi bi-box-arrow-right"></i></button>
                </form>
            </div>
        </div>

        <div class="d-flex justify-content-center gap-1 pb-2 flex-wrap">
            @if (auth()->user()->role === 'admin')
                <a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a>
                <a href="{{ route('transaksi.index') }}" class="nav-link">Data Pesanan</a>
                <a href="{{ route('paket.index') }}" class="nav-link">Paket Layanan</a>
                <a href="{{ route('mitra.index') }}" class="nav-link">Data Mitra</a>
                <a href="{{ route('laporan.index') }}" class="nav-link">Laporan</a>
                <a href="{{ route('komplain.index') }}" class="nav-link">Komplain</a>
            @elseif (auth()->user()->role === 'mitra')
                <a href="{{ route('pesanan.masuk') }}" class="nav-link">Pesanan Masuk</a>
                <a href="{{ route('pesanan.tugasSaya') }}" class="nav-link">Tugas Saya</a>
                <a href="{{ route('mitra.jadwal') }}" class="nav-link active">Jadwal Saya</a>
                <a href="{{ route('mitra.riwayat') }}" class="nav-link">Riwayat & Pendapatan</a>
            @else
                <a href="{{ route('pesanan.katalog') }}" class="nav-link">Katalog</a>
                <a href="{{ route('pesanan.riwayat') }}" class="nav-link">Riwayat</a>
            @endif
            <a href="{{ route('profile.edit') }}" class="nav-link">Pengaturan</a>
        </div>
    </div>
</nav>

<div class="main-content">
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @yield('content')
</div>

</body>
</html>