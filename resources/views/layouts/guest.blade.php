<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'FreshLiving') }}</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body { font-family: 'Plus Jakarta Sans', sans-serif; margin: 0; background: #f4f7fb; color: #12293f; }
            .fl-shell { display: flex; min-height: 100vh; }

            /* Panel kiri */
            .fl-brand-panel { flex: 0 0 45%; max-width: 680px; position: relative; overflow: hidden; background: linear-gradient(160deg, #1f4e79 0%, #123049 100%); color: #fff; padding: 3rem 3.5rem; display: flex; flex-direction: column; justify-content: space-between; }
            .fl-circle { position: absolute; border-radius: 50%; background: rgba(255,255,255,0.06); }
            .fl-c1 { width: 420px; height: 420px; top: -140px; right: -140px; }
            .fl-c2 { width: 280px; height: 280px; bottom: -90px; left: -90px; }
            .fl-logo, .fl-hero, .fl-brand-foot { position: relative; z-index: 2; }
            .fl-logo { display: flex; align-items: center; gap: 10px; font-size: 20px; font-weight: 800; color: #fff; text-decoration: none; }
            .fl-logo i { font-size: 26px; }
            .fl-logo small { display: block; font-size: 11px; font-weight: 500; opacity: .7; letter-spacing: .3px; }
            .fl-hero h2 { font-size: 2.4rem; font-weight: 800; line-height: 1.15; margin: 0 0 1rem; }
            .fl-hero > p { opacity: .8; font-size: 15px; line-height: 1.6; margin: 0 0 2rem; max-width: 430px; }
            .fl-points { list-style: none; margin: 0; padding: 0; }
            .fl-points li { display: flex; gap: 14px; align-items: flex-start; margin-bottom: 1.1rem; }
            .fl-points li > i { flex: 0 0 42px; height: 42px; border-radius: 12px; background: rgba(255,255,255,0.12); color: #8fd0ff; display: flex; align-items: center; justify-content: center; font-size: 19px; }
            .fl-points strong { display: block; font-size: 14px; font-weight: 700; }
            .fl-points span { display: block; font-size: 13px; opacity: .7; margin-top: 2px; }
            .fl-brand-foot { font-size: 12px; opacity: .55; }

            /* Panel kanan */
            .fl-form-panel { flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 2rem 1.25rem; }
            .fl-mobile-brand { display: none; align-items: center; gap: 8px; color: #1f4e79; font-weight: 800; font-size: 20px; margin-bottom: 1.5rem; text-decoration: none; }
            .fl-form-wrap { width: 100%; max-width: 440px; background: #fff; border-radius: 22px; box-shadow: 0 20px 50px rgba(18,48,73,0.10); padding: 2.3rem; }

            .fl-head h1 { font-size: 1.6rem; font-weight: 800; color: #12293f; margin: 0 0 6px; }
            .fl-head p { color: #6b7f92; font-size: 14px; margin: 0 0 1.6rem; }
            .fl-field { margin-bottom: 1rem; }
            .fl-label { display: block; font-size: 13px; font-weight: 600; color: #33475b; margin-bottom: 6px; }
            .fl-input-wrap { position: relative; }
            .fl-ico { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #8aa0b4; font-size: 16px; pointer-events: none; }
            .fl-input { width: 100%; box-sizing: border-box; border: 1.5px solid #d9e2ec; border-radius: 12px; padding: 12px 14px 12px 42px; font-size: 14px; font-family: inherit; background: #fff; color: #12293f; transition: border-color .15s, box-shadow .15s; }
            .fl-input:focus { outline: none; border-color: #1f4e79; box-shadow: 0 0 0 4px rgba(31,78,121,0.12); }
            .fl-input.is-invalid { border-color: #dc3545; }
            .fl-input.has-eye { padding-right: 44px; }
            .fl-eye { position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: 0; color: #8aa0b4; cursor: pointer; padding: 6px; font-size: 16px; }
            .fl-eye:hover { color: #1f4e79; }
            .fl-error { color: #dc3545; font-size: 12px; margin-top: 5px; }
            .fl-alert { padding: 10px 14px; border-radius: 12px; font-size: 13px; margin-bottom: 1rem; background: #e8f7ee; color: #1b7a43; }

            .fl-row { display: flex; justify-content: space-between; align-items: center; margin: .25rem 0 1.4rem; font-size: 13px; }
            .fl-remember { display: flex; align-items: center; gap: 8px; color: #4a5b6b; cursor: pointer; }
            .fl-check { width: 16px; height: 16px; border: 1.5px solid #b8c7d6; border-radius: 4px; color: #1f4e79; cursor: pointer; }
            .fl-link { color: #1f4e79; font-weight: 600; text-decoration: none; }
            .fl-link:hover { text-decoration: underline; }
            .fl-btn { display: block; width: 100%; border: 0; background: #1f4e79; color: #fff; font-family: inherit; font-weight: 700; font-size: 15px; border-radius: 12px; padding: 13px; cursor: pointer; transition: background .15s, transform .15s; }
            .fl-btn:hover { background: #173b5c; transform: translateY(-1px); }
            .fl-foot { text-align: center; margin-top: 1.4rem; font-size: 14px; color: #6b7f92; }

            /* Pilihan peran (register) */
            .fl-roles { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
            .fl-role { position: relative; display: block; cursor: pointer; }
            .fl-role-input { position: absolute; opacity: 0; pointer-events: none; }
            .fl-role-card { display: flex; flex-direction: column; align-items: flex-start; gap: 2px; height: 100%; box-sizing: border-box; border: 1.5px solid #d9e2ec; border-radius: 14px; padding: 12px 14px; transition: all .15s ease; }
            .fl-role-card i { font-size: 21px; color: #1f4e79; margin-bottom: 4px; }
            .fl-role-card strong { font-size: 14px; color: #12293f; }
            .fl-role-card small { font-size: 12px; color: #6b7f92; line-height: 1.35; }
            .fl-role-input:checked + .fl-role-card { border-color: #1f4e79; background: #eef4fb; box-shadow: 0 0 0 3px rgba(31,78,121,0.10); }
            .fl-mitra-box { background: #f6f9fc; border: 1px dashed #c5d5e4; border-radius: 14px; padding: 14px; margin-bottom: 1rem; }
            .fl-mitra-box > p { font-size: 12.5px; color: #5b6f82; margin: 0 0 12px; line-height: 1.5; }
            .fl-file { width: 100%; box-sizing: border-box; border: 1.5px dashed #b8c7d6; border-radius: 12px; padding: 10px; font-size: 13px; font-family: inherit; background: #fff; }
            .fl-file::file-selector-button { border: 0; background: #1f4e79; color: #fff; border-radius: 8px; padding: 7px 12px; margin-right: 12px; cursor: pointer; font-family: inherit; }

            @media (max-width: 991px) {
                .fl-brand-panel { display: none; }
                .fl-mobile-brand { display: flex; }
                .fl-form-panel { justify-content: flex-start; padding-top: 2.5rem; }
                .fl-form-wrap { padding: 1.7rem; }
            }
        </style>
    </head>
    <body>
        <div class="fl-shell">
            <aside class="fl-brand-panel">
                <span class="fl-circle fl-c1"></span>
                <span class="fl-circle fl-c2"></span>

                <a href="{{ url('/') }}" class="fl-logo">
                    <i class="bi bi-droplet-fill"></i>
                    <span>FreshLiving<small>Cleaning Services</small></span>
                </a>

                <div class="fl-hero">
                    <h2>Rumah bersih,<br>tanpa ribet.</h2>
                    <p>Pesan jasa cleaning service ke rumah atau kantormu kapan saja, langsung dari aplikasi.</p>
                    <ul class="fl-points">
                        <li>
                            <i class="bi bi-shield-check"></i>
                            <div><strong>Mitra terverifikasi</strong><span>Identitas dicek Admin sebelum menerima pesanan</span></div>
                        </li>
                        <li>
                            <i class="bi bi-cash-coin"></i>
                            <div><strong>Harga transparan</strong><span>Harga tetap per paket, tanpa tawar-menawar</span></div>
                        </li>
                        <li>
                            <i class="bi bi-geo-alt"></i>
                            <div><strong>Lacak status pesanan</strong><span>Pantau dari dikonfirmasi sampai selesai</span></div>
                        </li>
                    </ul>
                </div>

                <div class="fl-brand-foot">&copy; {{ date('Y') }} FreshLiving Cleaning Services</div>
            </aside>

            <main class="fl-form-panel">
                <a href="{{ url('/') }}" class="fl-mobile-brand"><i class="bi bi-droplet-fill"></i> FreshLiving</a>
                <div class="fl-form-wrap">
                    {{ $slot }}
                </div>
            </main>
        </div>

        <script>
            document.querySelectorAll('[data-toggle-pass]').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    var input = document.getElementById(btn.dataset.togglePass);
                    var show = input.type === 'password';
                    input.type = show ? 'text' : 'password';
                    btn.innerHTML = show ? '<i class="bi bi-eye-slash"></i>' : '<i class="bi bi-eye"></i>';
                });
            });
        </script>
    </body>
</html>