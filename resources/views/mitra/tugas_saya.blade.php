@extends('layouts.dashboard')

@section('title', 'Tugas Saya')

@section('content')
    <style>
        .cek-item { width: 1.25rem; height: 1.25rem; margin-top: 0; cursor: pointer; flex-shrink: 0; }
        .cek-item:checked { background-color: #198754; border-color: #198754; }
        .cek-item:disabled { cursor: not-allowed; }
        .cek-label { cursor: pointer; margin: 0; }
        .cek-item:checked + .cek-label { text-decoration: line-through; color: #6c757d; }
        .cek-item:disabled + .cek-label { cursor: not-allowed; opacity: .7; }
    </style>

    <h3 class="mb-1">Tugas Saya</h3>
    <p class="text-muted mb-4">Pekerjaan yang sedang kamu jalani</p>

    @php
        $badgeColor = ['dikonfirmasi' => 'warning', 'menuju_lokasi' => 'info', 'sedang_mengerjakan' => 'primary'];
        $labelStatus = ['dikonfirmasi' => 'Dikonfirmasi', 'menuju_lokasi' => 'Menuju Lokasi', 'sedang_mengerjakan' => 'Sedang Dikerjakan'];
    @endphp

    @forelse ($pesanans as $pesanan)
        @php
            $grup = $pesanan->paketLayanan->grupChecklist();
            $semuaKunci = $pesanan->paketLayanan->semuaKunciChecklist();
            $selesaiKunci = $pesanan->checklist_selesai ?? [];
            $totalItem = count($semuaKunci);
            $jumlahSelesai = count(array_intersect($selesaiKunci, $semuaKunci));
            $bolehSebelum = in_array($pesanan->status, ['menuju_lokasi', 'sedang_mengerjakan'], true);
            $bolehLain = $pesanan->status === 'sedang_mengerjakan';
        @endphp

        <div class="bg-white rounded-4 shadow-sm p-4 mb-3 kartu-tugas" data-url="{{ route('pesanan.checklist', $pesanan) }}">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                <div>
                    <span class="badge rounded-pill bg-{{ $badgeColor[$pesanan->status] ?? 'secondary' }}-subtle text-{{ $badgeColor[$pesanan->status] ?? 'secondary' }} px-3 py-2 mb-2">
                        {{ $labelStatus[$pesanan->status] ?? $pesanan->status }}
                    </span>
                    <div class="fw-bold fs-5">{{ $pesanan->paketLayanan->nama_paket }}</div>
                    <small class="text-muted d-block mt-1"><i class="bi bi-geo-alt me-1"></i>{{ $pesanan->alamat }}</small>
                </div>

                <div>
                    @if ($pesanan->status === 'dikonfirmasi')
                        <form action="{{ route('pesanan.updateStatus', $pesanan) }}" method="POST">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="menuju_lokasi">
                            <button class="btn btn-primary"><i class="bi bi-arrow-right me-1"></i>Menuju Lokasi</button>
                        </form>
                    @elseif ($pesanan->status === 'menuju_lokasi')
                        <form action="{{ route('pesanan.updateStatus', $pesanan) }}" method="POST">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="sedang_mengerjakan">
                            <button class="btn btn-primary"><i class="bi bi-tools me-1"></i>Mulai Kerjakan</button>
                        </form>
                    @elseif ($pesanan->status === 'sedang_mengerjakan')
                        <div class="d-flex flex-column gap-2">
                            <form action="{{ route('pesanan.updateStatus', $pesanan) }}" method="POST" onsubmit="return konfirmasiSelesai(this)">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="selesai">
                                <button class="btn btn-success w-100"><i class="bi bi-check-lg me-1"></i>Tandai Selesai</button>
                            </form>
                            @if ($pesanan->metode_pembayaran === 'cod' && $pesanan->status_pembayaran !== 'lunas')
                                <form action="{{ route('pembayaran.konfirmasiCod', $pesanan) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-outline-success btn-sm w-100"><i class="bi bi-cash-coin me-1"></i>Konfirmasi Uang COD Diterima</button>
                                </form>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            <div class="mt-3 pt-3 border-top">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="fw-bold mb-0">Checklist SOP</h6>
                    <small class="text-muted"><span class="jumlah-selesai">{{ $jumlahSelesai }}</span>/{{ $totalItem }} selesai</small>
                </div>
                <div class="progress mb-3" style="height:6px;">
                    <div class="progress-bar bg-success bar-progres" style="width: {{ $totalItem ? ($jumlahSelesai / $totalItem * 100) : 0 }}%"></div>
                </div>

                @foreach ($grup as $kodeGrup => $g)
                    @continue(count($g['items']) === 0)
                    @php $boleh = $kodeGrup === 'sebelum' ? $bolehSebelum : $bolehLain; @endphp

                    <div class="mb-3">
                        <div class="small fw-semibold text-uppercase text-muted mb-2" style="letter-spacing:.4px;">
                            <i class="bi {{ $g['ikon'] }} me-1"></i>{{ $g['judul'] }}
                        </div>
                        @foreach ($g['items'] as $i => $item)
                            @php $kunci = $kodeGrup . ':' . $i; @endphp
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <input type="checkbox" class="form-check-input cek-item"
                                       id="cek-{{ $pesanan->id }}-{{ $kodeGrup }}-{{ $i }}" data-kunci="{{ $kunci }}"
                                       {{ in_array($kunci, $selesaiKunci, true) ? 'checked' : '' }}
                                       {{ $boleh ? '' : 'disabled' }}>
                                <label class="cek-label" for="cek-{{ $pesanan->id }}-{{ $kodeGrup }}-{{ $i }}">{{ $item }}</label>
                            </div>
                        @endforeach
                    </div>
                @endforeach

                @unless ($bolehLain)
                    <small class="text-muted d-block">
                        <i class="bi bi-info-circle me-1"></i>
                        SOP Sebelum bisa diisi setelah kamu menekan <strong>Menuju Lokasi</strong>. Pekerjaan dan SOP Setelah bisa diisi setelah menekan <strong>Mulai Kerjakan</strong>.
                    </small>
                @endunless
            </div>
        </div>
    @empty
        <div class="bg-white rounded-4 shadow-sm text-center text-muted py-5">
            <i class="bi bi-list-check fs-1 d-block mb-2 opacity-25"></i>
            Belum ada tugas aktif.
        </div>
    @endforelse

    <script>
        (function () {
            var csrf = '{{ csrf_token() }}';

            function perbaruiProgres(kartu) {
                var semua = kartu.querySelectorAll('.cek-item');
                var tercentang = kartu.querySelectorAll('.cek-item:checked').length;
                var teks = kartu.querySelector('.jumlah-selesai');
                var bar = kartu.querySelector('.bar-progres');
                if (teks) teks.textContent = tercentang;
                if (bar) bar.style.width = (semua.length ? (tercentang / semua.length * 100) : 0) + '%';
            }

            document.querySelectorAll('.cek-item').forEach(function (cb) {
                cb.addEventListener('change', function () {
                    var kartu = cb.closest('.kartu-tugas');
                    var dicentang = cb.checked;
                    cb.disabled = true;
                    perbaruiProgres(kartu);

                    fetch(kartu.dataset.url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrf,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({ kunci: cb.dataset.kunci, checked: dicentang })
                    }).then(function (res) {
                        if (!res.ok) throw new Error('gagal');
                        cb.disabled = false;
                    }).catch(function () {
                        cb.checked = !dicentang;
                        cb.disabled = false;
                        perbaruiProgres(kartu);
                        alert('Checklist gagal disimpan. Muat ulang halaman lalu coba lagi.');
                    });
                });
            });

            window.konfirmasiSelesai = function (form) {
                var kartu = form.closest('.kartu-tugas');
                var semua = kartu.querySelectorAll('.cek-item');
                if (semua.length === 0) return true;
                var sisa = semua.length - kartu.querySelectorAll('.cek-item:checked').length;
                if (sisa > 0) {
                    return confirm('Masih ada ' + sisa + ' item checklist yang belum dicentang. Tetap tandai selesai?');
                }
                return true;
            };
        })();
    </script>
@endsection
