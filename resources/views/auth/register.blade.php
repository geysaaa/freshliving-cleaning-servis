@php
    $mulaiLangkah2 = old('daftar_sebagai') === 'mitra'
        && ($errors->has('area_layanan') || $errors->has('keahlian') || $errors->has('foto_ktp'))
        && !$errors->has('name') && !$errors->has('email') && !$errors->has('password');
@endphp

<x-guest-layout>
    <style>
        .fl-stepper { display: flex; align-items: center; gap: 10px; margin-bottom: 1.4rem; }
        .fl-step { display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 600; color: #8aa0b4; }
        .fl-step span { width: 26px; height: 26px; border-radius: 50%; background: #e3ebf3; color: #6b7f92; display: flex; align-items: center; justify-content: center; font-size: 12px; }
        .fl-step.is-active { color: #1f4e79; }
        .fl-step.is-active span { background: #1f4e79; color: #fff; }
        .fl-step.is-done { color: #1b7a43; }
        .fl-step.is-done span { background: #1b7a43; color: #fff; }
        .fl-step-line { flex: 1; height: 2px; background: #e3ebf3; }
        .fl-btn-row { display: flex; gap: 10px; margin-top: 1.2rem; }
        .fl-btn-row .fl-btn { width: auto; flex: 1; }
        .fl-btn.fl-btn-ghost { background: #fff; color: #33475b; border: 1.5px solid #d9e2ec; }
        .fl-btn.fl-btn-ghost:hover { background: #f4f7fb; transform: none; }
        .fl-note { background: #eef4fb; color: #3d5a75; border-radius: 12px; padding: 11px 14px; font-size: 12.5px; line-height: 1.5; margin-bottom: 1.1rem; }
    </style>

    <div class="fl-head">
        <h1 id="judulForm">Buat akun baru</h1>
        <p id="subJudul">Daftar gratis untuk mulai memesan atau menjadi mitra.</p>
    </div>

    <div id="stepper" class="fl-stepper" style="display:none;">
        <div class="fl-step is-active" id="st1"><span>1</span> Akun</div>
        <div class="fl-step-line"></div>
        <div class="fl-step" id="st2"><span>2</span> Data Mitra</div>
    </div>

    <form id="formRegister" method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf

        {{-- LANGKAH 1 --}}
        <div id="langkah1">
            <div class="fl-field">
                <label class="fl-label" for="name">Nama lengkap</label>
                <div class="fl-input-wrap">
                    <i class="bi bi-person fl-ico"></i>
                    <input id="name" class="fl-input @error('name') is-invalid @enderror" type="text" name="name" value="{{ old('name') }}" placeholder="Nama kamu" required autofocus autocomplete="name">
                </div>
                @error('name') <div class="fl-error">{{ $message }}</div> @enderror
            </div>

            <div class="fl-field">
                <label class="fl-label" for="email">Email</label>
                <div class="fl-input-wrap">
                    <i class="bi bi-envelope fl-ico"></i>
                    <input id="email" class="fl-input @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required autocomplete="username">
                </div>
                @error('email') <div class="fl-error">{{ $message }}</div> @enderror
            </div>

            <div class="fl-field">
                <label class="fl-label" for="password">Password</label>
                <div class="fl-input-wrap">
                    <i class="bi bi-lock fl-ico"></i>
                    <input id="password" class="fl-input has-eye @error('password') is-invalid @enderror" type="password" name="password" placeholder="Minimal 8 karakter" minlength="8" required autocomplete="new-password">
                    <button type="button" class="fl-eye" data-toggle-pass="password"><i class="bi bi-eye"></i></button>
                </div>
                @error('password') <div class="fl-error">{{ $message }}</div> @enderror
            </div>

            <div class="fl-field">
                <label class="fl-label" for="password_confirmation">Konfirmasi password</label>
                <div class="fl-input-wrap">
                    <i class="bi bi-shield-lock fl-ico"></i>
                    <input id="password_confirmation" class="fl-input has-eye" type="password" name="password_confirmation" placeholder="Ulangi password" required autocomplete="new-password">
                    <button type="button" class="fl-eye" data-toggle-pass="password_confirmation"><i class="bi bi-eye"></i></button>
                </div>
                <div class="fl-error" id="errCocok" style="display:none;">Konfirmasi password tidak sama.</div>
            </div>

            <div class="fl-field">
                <label class="fl-label">Daftar sebagai</label>
                <div class="fl-roles">
                    <label class="fl-role">
                        <input type="radio" name="daftar_sebagai" value="pelanggan" class="fl-role-input" {{ old('daftar_sebagai', 'pelanggan') === 'pelanggan' ? 'checked' : '' }}>
                        <span class="fl-role-card">
                            <i class="bi bi-person-heart"></i>
                            <strong>Pelanggan</strong>
                            <small>Ingin memesan jasa cleaning</small>
                        </span>
                    </label>
                    <label class="fl-role">
                        <input type="radio" name="daftar_sebagai" value="mitra" class="fl-role-input" {{ old('daftar_sebagai') === 'mitra' ? 'checked' : '' }}>
                        <span class="fl-role-card">
                            <i class="bi bi-briefcase"></i>
                            <strong>Mitra</strong>
                            <small>Ingin menjadi petugas cleaning</small>
                        </span>
                    </label>
                </div>
                @error('daftar_sebagai') <div class="fl-error">{{ $message }}</div> @enderror
            </div>

            <button type="submit" id="btnDaftar" class="fl-btn" style="margin-top:1.2rem;">Buat Akun</button>
            <button type="button" id="btnLanjut" class="fl-btn" style="margin-top:1.2rem; display:none;">Lanjut <i class="bi bi-arrow-right ms-1"></i></button>
        </div>

        {{-- LANGKAH 2 (khusus Mitra) --}}
        <div id="langkah2" style="display:none;">
            <div class="fl-note"><i class="bi bi-info-circle me-1"></i>Lengkapi data berikut supaya Admin bisa memverifikasi akunmu.</div>

            <div class="fl-field">
                <label class="fl-label" for="area_layanan">Area layanan</label>
                <div class="fl-input-wrap">
                    <i class="bi bi-geo-alt fl-ico"></i>
                    <input id="area_layanan" class="fl-input @error('area_layanan') is-invalid @enderror" type="text" name="area_layanan" value="{{ old('area_layanan') }}" placeholder="Contoh: Surabaya Timur, Rungkut">
                </div>
                @error('area_layanan') <div class="fl-error">{{ $message }}</div> @enderror
            </div>

            <div class="fl-field">
                <label class="fl-label" for="keahlian">Keahlian</label>
                <div class="fl-input-wrap">
                    <i class="bi bi-tools fl-ico"></i>
                    <input id="keahlian" class="fl-input @error('keahlian') is-invalid @enderror" type="text" name="keahlian" value="{{ old('keahlian') }}" placeholder="Contoh: General cleaning, cuci sofa">
                </div>
                @error('keahlian') <div class="fl-error">{{ $message }}</div> @enderror
            </div>

            <div class="fl-field">
                <label class="fl-label" for="foto_ktp">Foto KTP</label>
                <input id="foto_ktp" class="fl-file" type="file" name="foto_ktp" accept="image/*">
                @error('foto_ktp') <div class="fl-error">{{ $message }}</div> @enderror
            </div>

            <div class="fl-btn-row">
                <button type="button" id="btnKembali" class="fl-btn fl-btn-ghost"><i class="bi bi-arrow-left me-1"></i>Kembali</button>
                <button type="submit" class="fl-btn">Buat Akun</button>
            </div>
        </div>
    </form>

    <div class="fl-foot">
        Sudah punya akun? <a class="fl-link" href="{{ route('login') }}">Masuk</a>
    </div>

    <script>
        (function () {
            var form = document.getElementById('formRegister');
            var l1 = document.getElementById('langkah1');
            var l2 = document.getElementById('langkah2');
            var btnDaftar = document.getElementById('btnDaftar');
            var btnLanjut = document.getElementById('btnLanjut');
            var btnKembali = document.getElementById('btnKembali');
            var stepper = document.getElementById('stepper');
            var st1 = document.getElementById('st1');
            var st2 = document.getElementById('st2');
            var judul = document.getElementById('judulForm');
            var sub = document.getElementById('subJudul');
            var area = document.getElementById('area_layanan');
            var keahlian = document.getElementById('keahlian');
            var pass = document.getElementById('password');
            var pass2 = document.getElementById('password_confirmation');
            var errCocok = document.getElementById('errCocok');
            var step = {{ $mulaiLangkah2 ? 2 : 1 }};

            function isMitra() {
                return document.querySelector('input[name="daftar_sebagai"]:checked').value === 'mitra';
            }

            function render() {
                var mitra = isMitra();
                if (!mitra) step = 1;

                l1.style.display = step === 1 ? 'block' : 'none';
                l2.style.display = step === 2 ? 'block' : 'none';
                btnDaftar.style.display = mitra ? 'none' : 'block';
                btnLanjut.style.display = mitra ? 'block' : 'none';
                stepper.style.display = mitra ? 'flex' : 'none';

                st1.className = 'fl-step ' + (step === 1 ? 'is-active' : 'is-done');
                st1.querySelector('span').innerHTML = step === 2 ? '<i class="bi bi-check-lg"></i>' : '1';
                st2.className = 'fl-step ' + (step === 2 ? 'is-active' : '');

                judul.textContent = step === 2 ? 'Lengkapi data mitra' : 'Buat akun baru';
                sub.textContent = step === 2
                    ? 'Akun mitra diverifikasi Admin sebelum bisa menerima pesanan.'
                    : 'Daftar gratis untuk mulai memesan atau menjadi mitra.';

                area.required = mitra && step === 2;
                keahlian.required = mitra && step === 2;
            }

            function validasiLangkah1() {
                var fields = [document.getElementById('name'), document.getElementById('email'), pass, pass2];
                for (var i = 0; i < fields.length; i++) {
                    if (!fields[i].checkValidity()) { fields[i].reportValidity(); return false; }
                }
                if (pass.value !== pass2.value) {
                    errCocok.style.display = 'block';
                    pass2.focus();
                    return false;
                }
                errCocok.style.display = 'none';
                return true;
            }

            btnLanjut.addEventListener('click', function () {
                if (validasiLangkah1()) {
                    step = 2;
                    render();
                    area.focus();
                }
            });

            btnKembali.addEventListener('click', function () {
                step = 1;
                render();
            });

            // Tekan Enter di langkah 1 (mitra) = lanjut, bukan kirim form
            form.addEventListener('submit', function (e) {
                if (isMitra() && step === 1) {
                    e.preventDefault();
                    btnLanjut.click();
                }
            });

            document.querySelectorAll('input[name="daftar_sebagai"]').forEach(function (r) {
                r.addEventListener('change', render);
            });

            render();
        })();
    </script>
</x-guest-layout>